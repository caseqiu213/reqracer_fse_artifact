jQuery.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
  // Modify options, control originalOptions, store jqXHR, etc
  // use document.querySelector().content to get the token value 
  // add token value to ajax request
  // 
  options.url = options.url + '&racetrkr_nonce=' + document.querySelector('meta[type=racetrkr]').content ;
  console.log(options);
});