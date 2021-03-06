var tagBox, commentsBox, editPermalink, makeSlugeditClickable, WPSetThumbnailHTML, WPSetThumbnailID, WPRemoveThumbnail;

// return an array with any duplicate, whitespace or values removed
function array_unique_noempty(a) {
	var out = [];
	jQuery.each( a, function(key, val) {
		val = jQuery.trim(val);
		if ( val && jQuery.inArray(val, out) == -1 )
			out.push(val);
		} );
	return out;
}

(function($){

tagBox = {
	clean : function(tags) {
		return tags.replace(/\s*,\s*/g, ',').replace(/,+/g, ',').replace(/[,\s]+$/, '').replace(/^[,\s]+/, '');
	},

	parseTags : function(el) {
		var id = el.id, num = id.split('-check-num-')[1], taxbox = $(el).closest('.tagsdiv'), thetags = taxbox.find('.the-tags'), current_tags = thetags.val().split(','), new_tags = [];
		delete current_tags[num];

		$.each( current_tags, function(key, val) {
			val = $.trim(val);
			if ( val ) {
				new_tags.push(val);
			}
		});

		thetags.val( this.clean( new_tags.join(',') ) );

		this.quickClicks(taxbox);
		return false;
	},

	quickClicks : function(el) {
		var thetags = $('.the-tags', el), tagchecklist = $('.tagchecklist', el), current_tags;

		if ( !thetags.length )
			return;

		current_tags = thetags.val().split(',');
		tagchecklist.empty();

		$.each( current_tags, function( key, val ) {
			var txt, button_id, id = $(el).attr('id');

			val = $.trim(val);
			if ( !val.match(/^\s+$/) && '' != val ) {
				button_id = id + '-check-num-' + key;
	 			txt = '<span><a id="' + button_id + '" class="ntdelbutton">X</a>&nbsp;' + val + '</span> ';
	 			tagchecklist.append(txt);
	 			$( '#' + button_id ).click( function(){ tagBox.parseTags(this); });
			}
		});
	},

	flushTags : function(el, a, f) {
		a = a || false;
		var text, tags = $('.the-tags', el), newtag = $('input.newtag', el), newtags;

		text = a ? $(a).text() : newtag.val();
		tagsval = tags.val();
		newtags = tagsval ? tagsval + ',' + text : text;

		newtags = this.clean( newtags );
		newtags = array_unique_noempty( newtags.split(',') ).join(',');
		tags.val(newtags);
		this.quickClicks(el);

		if ( !a )
			newtag.val('');
		if ( 'undefined' == f )
			newtag.focus();

		return false;
	},

	get : function(id) {
		var tax = id.substr(id.indexOf('-')+1);

		$.post(ajaxurl, {'action':'get-tagcloud','tax':tax}, function(r, stat) {
			if ( 0 == r || 'success' != stat )
				r = wpAjax.broken;

			r = $('<p id="tagcloud-'+tax+'" class="the-tagcloud">'+r+'</p>');
			$('a', r).click(function(){
				tagBox.flushTags( $(this).closest('.inside').children('.tagsdiv'), this);
				return false;
			});

			$('#'+id).after(r);
		});
	},

	init : function() {
		var t = this, ajaxtag = $('div.ajaxtag');

	    $('.tagsdiv').each( function() {
	        tagBox.quickClicks(this);
	    });

		$('input.tagadd', ajaxtag).click(function(){
			t.flushTags( $(this).closest('.tagsdiv') );
		});

		$('div.taghint', ajaxtag).click(function(){
			$(this).css('visibility', 'hidden').siblings('.newtag').focus();
		});

		$('input.newtag', ajaxtag).blur(function() {
			if ( this.value == '' )
	            $(this).siblings('.taghint').css('visibility', '');
	    }).focus(function(){
			$(this).siblings('.taghint').css('visibility', 'hidden');
		}).keyup(function(e){
			if ( 13 == e.which ) {
				tagBox.flushTags( $(this).closest('.tagsdiv') );
				return false;
			}
		}).keypress(function(e){
			if ( 13 == e.which ) {
				e.preventDefault();
				return false;
			}
		}).each(function(){
			var tax = $(this).closest('div.tagsdiv').attr('id');
			$(this).suggest( ajaxurl + '?action=ajax-tag-search&tax=' + tax, { delay: 500, minchars: 2, multiple: true, multipleSep: ", " } );
		});

	    // save tags on post save/publish
	    $('#post').submit(function(){
			$('div.tagsdiv').each( function() {
	        	tagBox.flushTags(this, false, 1);
			});
		});

		// tag cloud
		$('a.tagcloud-link').click(function(){
			tagBox.get( $(this).attr('id') );
			$(this).unbind().click(function(){
				$(this).siblings('.the-tagcloud').toggle();
				return false;
			});
			return false;
		});
	}
};

commentsBox = {
	st : 0,

	get : function(total, num) {
		var st = this.st, data;
		if ( ! num )
			num = 20;

		this.st += num;
		this.total = total;
		$('#commentsdiv img.waiting').show();

		data = {
			'action' : 'get-comments',
			'mode' : 'single',
			'_ajax_nonce' : $('#add_comment_nonce').val(),
			'post_ID' : $('#post_ID').val(),
			'start' : st,
			'num' : num
		};

		$.post(ajaxurl, data,
			function(r) {
				r = wpAjax.parseAjaxResponse(r);
				$('#commentsdiv .widefat').show();
				$('#commentsdiv img.waiting').hide();

				if ( 'object' == typeof r && r.responses[0] ) {
					$('#the-comment-list').append( r.responses[0].data );

					theList = theExtraList = null;
					$("a[className*=':']").unbind();
					setCommentsList();

					if ( commentsBox.st > commentsBox.total )
						$('#show-comments').hide();
					else
						$('#show-comments').html(postL10n.showcomm);
					return;
				} else if ( 1 == r ) {
					$('#show-comments').parent().html(postL10n.endcomm);
					return;
				}

				$('#the-comment-list').append('<tr><td colspan="2">'+wpAjax.broken+'</td></tr>');
			}
		);

		return false;
	}
};

WPSetThumbnailHTML = function(html){
	$('.inside', '#postthumbnaildiv').html(html);
};

WPSetThumbnailID = function(id){
	var field = $('input[value=_thumbnail_id]', '#list-table');
	if ( field.size() > 0 ) {
		$('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(id);
	}
};

WPRemoveThumbnail = function(){
	$.post(ajaxurl, {
		action:"set-post-thumbnail", post_id: $('#post_ID').val(), thumbnail_id: -1, cookie: encodeURIComponent(document.cookie)
	}, function(str){
		if ( str == '0' ) {
			alert( setPostThumbnailL10n.error );
		} else {
			WPSetThumbnailHTML(str);
		}
	}
	);
};

})(jQuery);

jQuery(document).ready( function($) {
	var catAddAfter, stamp, visibility, sticky = '', post = 'post' == pagenow || 'post-new' == pagenow, page = 'page' == pagenow || 'page-new' == pagenow;

	// postboxes
	if ( post )
		postboxes.add_postbox_toggles('post');
	else if ( page )
		postboxes.add_postbox_toggles('page');

	// multi-taxonomies
	if ( $('#tagsdiv-post_tag').length ) {
		tagBox.init();
	} else {
		$('#side-sortables, #normal-sortables, #advanced-sortables').children('div.postbox').each(function(){
			if ( this.id.indexOf('tagsdiv-') === 0 ) {
				tagBox.init();
				return false;
			}
		});
	}

	// categories
	if ( $('#categorydiv').length ) {
		// TODO: move to jQuery 1.3+, support for multiple hierarchical taxonomies, see wp-lists.dev.js
		$('a', '#category-tabs').click(function(){
			var t = $(this).attr('href');
			$(this).parent().addClass('tabs').siblings('li').removeClass('tabs');
			$('#category-tabs').siblings('.tabs-panel').hide();
			$(t).show();
			if ( '#categories-all' == t )
				deleteUserSetting('cats');
			else
				setUserSetting('cats','pop');
			return false;
		});
		if ( getUserSetting('cats') )
			$('a[href="#categories-pop"]', '#category-tabs').click();

		// Ajax Cat
		$('#newcat').one( 'focus', function() { $(this).val( '' ).removeClass( 'form-input-tip' ) } );
		$('#category-add-sumbit').click( function(){ $('#newcat').focus(); } );

		catAddBefore = function( s ) {
			if ( !$('#newcat').val() )
				return false;
			s.data += '&' + $( ':checked', '#categorychecklist' ).serialize();
			return s;
		};

		catAddAfter = function( r, s ) {
			var sup, drop = $('#newcat_parent');

			if ( 'undefined' != s.parsed.responses[0] && (sup = s.parsed.responses[0].supplemental.newcat_parent) ) {
				drop.before(sup);
				drop.remove();
			}
		};

		$('#categorychecklist').wpList({
			alt: '',
			response: 'category-ajax-response',
			addBefore: catAddBefore,
			addAfter: catAddAfter
		});

		$('#category-add-toggle').click( function() {
			$('#category-adder').toggleClass( 'wp-hidden-children' );
			$('a[href="#categories-all"]', '#category-tabs').click();
			return false;
		});

		$('#categorychecklist').children('li.popular-category').add( $('#categorychecklist-pop').children() ).find(':checkbox').live( 'click', function(){
			var t = $(this), c = t.is(':checked'), id = t.val();
			$('#in-category-' + id + ', #in-popular-category-' + id).attr( 'checked', c );
		});

	} // end cats

	// Custom Fields
	if ( $('#postcustom').length ) {
		$('#the-list').wpList( { addAfter: function( xml, s ) {
			$('table#list-table').show();
			if ( typeof( autosave_update_post_ID ) != 'undefined' ) {
				autosave_update_post_ID(s.parsed.responses[0].supplemental.postid);
			}
		}, addBefore: function( s ) {
			s.data += '&post_id=' + $('#post_ID').val();
			return s;
		}
		});
	}

	// submitdiv
	if ( $('#submitdiv').length ) {
		stamp = $('#timestamp').html();
		visibility = $('#post-visibility-display').html();

		function updateVisibility() {
			var pvSelect = $('#post-visibility-select');
			if ( $('input:radio:checked', pvSelect).val() != 'public' ) {
				$('#sticky').attr('checked', false);
				$('#sticky-span').hide();
			} else {
				$('#sticky-span').show();
			}
			if ( $('input:radio:checked', pvSelect).val() != 'password' ) {
				$('#password-span').hide();
			} else {
				$('#password-span').show();
			}
		}

		function updateText() {
			var attemptedDate, originalDate, currentDate, publishOn, postStatus = $('#post_status'), optPublish = $('option[value=publish]', postStatus);

			attemptedDate = new Date( $('#aa').val(), $('#mm').val() -1, $('#jj').val(), $('#hh').val(), $('#mn').val() );
			originalDate = new Date( $('#hidden_aa').val(), $('#hidden_mm').val() -1, $('#hidden_jj').val(), $('#hidden_hh').val(), $('#hidden_mn').val() );
			currentDate = new Date( $('#cur_aa').val(), $('#cur_mm').val() -1, $('#cur_jj').val(), $('#cur_hh').val(), $('#cur_mn').val() );
			if ( attemptedDate > currentDate && $('#original_post_status').val() != 'future' ) {
				publishOn = postL10n.publishOnFuture;
				$('#publish').val( postL10n.schedule );
			} else if ( attemptedDate <= currentDate && $('#original_post_status').val() != 'publish' ) {
				publishOn = postL10n.publishOn;
				$('#publish').val( postL10n.publish );
			} else {
				publishOn = postL10n.publishOnPast;
				if ( page )
					$('#publish').val( postL10n.updatePage );
				else
					$('#publish').val( postL10n.updatePost );
			}
			if ( originalDate.toUTCString() == attemptedDate.toUTCString() ) { //hack
				$('#timestamp').html(stamp);
			} else {
				$('#timestamp').html(
					publishOn + ' <b>' +
					$('option[value=' + $('#mm').val() + ']', '#mm').text() + ' ' +
					$('#jj').val() + ', ' +
					$('#aa').val() + ' @ ' +
					$('#hh').val() + ':' +
					$('#mn').val() + '</b> '
				);
			}

			if ( $('input:radio:checked', '#post-visibility-select').val() == 'private' ) {
				if ( page )
					$('#publish').val( postL10n.updatePage );
				else
					$('#publish').val( postL10n.updatePost );
				if ( optPublish.length == 0 ) {
					postStatus.append('<option value="publish">' + postL10n.privatelyPublished + '</option>');
				} else {
					optPublish.html( postL10n.privatelyPublished );
				}
				$('option[value=publish]', postStatus).attr('selected', true);
				$('.edit-post-status', '#misc-publishing-actions').hide();
			} else {
				if ( $('#original_post_status').val() == 'future' || $('#original_post_status').val() == 'draft' ) {
					if ( optPublish.length ) {
						optPublish.remove();
						postStatus.val($('#hidden_post_status').val());
					}
				} else {
					optPublish.html( postL10n.published );
				}
				$('.edit-post-status', '#misc-publishing-actions').show();
			}
			$('#post-status-display').html($('option:selected', postStatus).text());
			if ( $('option:selected', postStatus).val() == 'private' || $('option:selected', postStatus).val() == 'publish' ) {
				$('#save-post').hide();
			} else {
				$('#save-post').show();
				if ( $('option:selected', postStatus).val() == 'pending' ) {
					$('#save-post').show().val( postL10n.savePending );
				} else {
					$('#save-post').show().val( postL10n.saveDraft );
				}
			}
		}

		$('.edit-visibility', '#visibility').click(function () {
			if ($('#post-visibility-select').is(":hidden")) {
				updateVisibility();
				$('#post-visibility-select').slideDown("normal");
				$(this).hide();
			}
			return false;
		});

		$('.cancel-post-visibility', '#post-visibility-select').click(function () {
			$('#post-visibility-select').slideUp("normal");
			$('#visibility-radio-' + $('#hidden-post-visibility').val()).attr('checked', true);
			$('#post_password').val($('#hidden_post_password').val());
			$('#sticky').attr('checked', $('#hidden-post-sticky').attr('checked'));
			$('#post-visibility-display').html(visibility);
			$('.edit-visibility', '#visibility').show();
			updateText();
			return false;
		});

		$('.save-post-visibility', '#post-visibility-select').click(function () { // crazyhorse - multiple ok cancels
			var pvSelect = $('#post-visibility-select');

			pvSelect.slideUp("normal");
			$('.edit-visibility', '#visibility').show();
			updateText();

			if ( $('input:radio:checked', pvSelect).val() != 'public' ) {
				$('#sticky').attr('checked', false);
			}

			if ( true == $('#sticky').attr('checked') ) {
				sticky = 'Sticky';
			} else {
				sticky = '';
			}

			$('#post-visibility-display').html(	postL10n[$('input:radio:checked', pvSelect).val() + sticky]	);
			return false;
		});

		$('input:radio', '#post-visibility-select').change(function() {
			updateVisibility();
		});

		$('#timestampdiv').siblings('a.edit-timestamp').click(function() {
			if ($('#timestampdiv').is(":hidden")) {
				$('#timestampdiv').slideDown("normal");
				$(this).hide();
			}
			return false;
		});

		$('.cancel-timestamp', '#timestampdiv').click(function() {
			$('#timestampdiv').slideUp("normal");
			$('#mm').val($('#hidden_mm').val());
			$('#jj').val($('#hidden_jj').val());
			$('#aa').val($('#hidden_aa').val());
			$('#hh').val($('#hidden_hh').val());
			$('#mn').val($('#hidden_mn').val());
			$('#timestampdiv').siblings('a.edit-timestamp').show();
			updateText();
			return false;
		});

		$('.save-timestamp', '#timestampdiv').click(function () { // crazyhorse - multiple ok cancels
			$('#timestampdiv').slideUp("normal");
			$('#timestampdiv').siblings('a.edit-timestamp').show();
			updateText();
			return false;
		});

		$('#post-status-select').siblings('a.edit-post-status').click(function() {
			if ($('#post-status-select').is(":hidden")) {
				$('#post-status-select').slideDown("normal");
				$(this).hide();
			}
			return false;
		});

		$('.save-post-status', '#post-status-select').click(function() {
			$('#post-status-select').slideUp("normal");
			$('#post-status-select').siblings('a.edit-post-status').show();
			updateText();
			return false;
		});

		$('.cancel-post-status', '#post-status-select').click(function() {
			$('#post-status-select').slideUp("normal");
			$('#post_status').val($('#hidden_post_status').val());
			$('#post-status-select').siblings('a.edit-post-status').show();
			updateText();
			return false;
		});
	} // end submitdiv

	// permalink
	if ( $('#edit-slug-box').length ) {
		editPermalink = function(post_id) {
			var i, c = 0, e = $('#editable-post-name'), revert_e = e.html(), real_slug = $('#post_name'), revert_slug = real_slug.html(), b = $('#edit-slug-buttons'), revert_b = b.html(), full = $('#editable-post-name-full').html();

			$('#view-post-btn').hide();
			b.html('<a href="#" class="save button">'+postL10n.ok+'</a> <a class="cancel" href="#">'+postL10n.cancel+'</a>');
			b.children('.save').click(function() {
				var new_slug = e.children('input').val();
				$.post(ajaxurl, {
					action: 'sample-permalink',
					post_id: post_id,
					new_slug: new_slug,
					new_title: $('#title').val(),
					samplepermalinknonce: $('#samplepermalinknonce').val()
				}, function(data) {
					$('#edit-slug-box').html(data);
					b.html(revert_b);
					real_slug.attr('value', new_slug);
					makeSlugeditClickable();
					$('#view-post-btn').show();
				});
				return false;
			});

			$('.cancel', '#edit-slug-buttons').click(function() {
				$('#view-post-btn').show();
				e.html(revert_e);
				b.html(revert_b);
				real_slug.attr('value', revert_slug);
				return false;
			});

			for ( i = 0; i < full.length; ++i ) {
				if ( '%' == full.charAt(i) )
					c++;
			}

			slug_value = ( c > full.length / 4 ) ? '' : full;
			e.html('<input type="text" id="new-post-slug" value="'+slug_value+'" />').children('input').keypress(function(e){
				var key = e.keyCode || 0;
				// on enter, just save the new slug, don't save the post
				if ( 13 == key ) {
					b.children('.save').click();
					return false;
				}
				if ( 27 == key ) {
					b.children('.cancel').click();
					return false;
				}
				real_slug.attr('value', this.value);
			}).focus();
		}

		makeSlugeditClickable = function() {
			$('#editable-post-name').click(function() {
				$('#edit-slug-buttons').children('.edit-slug').click();
			});
		}
		makeSlugeditClickable();
	}
});
