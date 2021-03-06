<?php
/** Cornish (kernowek)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Kernoweger
 * @author Kw-Moon
 * @author MF-Warburg
 * @author Malafaya
 * @author Mongvras
 * @author Nicky.ker
 * @author Nrowe
 * @author Scryfer
 */

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Arbennek',
	NS_TALK             => 'Kescows',
	NS_USER             => 'Devnydhyer',
	NS_USER_TALK        => 'Kescows_Devnydhyer',
	NS_PROJECT_TALK     => 'Kescows_$1',
	NS_FILE             => 'Restren',
	NS_FILE_TALK        => 'Kescows_Restren',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Kescows_MediaWiki',
	NS_TEMPLATE         => 'Scantlyn',
	NS_TEMPLATE_TALK    => 'Kescows_Scantlyn',
	NS_HELP             => 'Gweres',
	NS_HELP_TALK        => 'Kescows_Gweres',
	NS_CATEGORY         => 'Class',
	NS_CATEGORY_TALK    => 'Kescows_Class',
);

$namespaceAliases = array(
	'Arbednek'           => NS_SPECIAL,
	'Cows'               => NS_TALK,
	'Keskows'            => NS_TALK,
	'Cows_Devnydhyer'    => NS_USER_TALK,
	'Keskows_Devnydhyer' => NS_USER_TALK,
	'Cows_$1'            => NS_PROJECT_TALK,
	'Keskows_$1'         => NS_PROJECT_TALK,
	'Cows_Restren'       => NS_FILE_TALK,
	'Keskows_Restren'    => NS_FILE_TALK,
	'Cows_MediaWiki'     => NS_MEDIAWIKI_TALK,
	'Cows_MediaWiki'     => NS_MEDIAWIKI_TALK,
	'Keskows_MediaWiki'  => NS_MEDIAWIKI_TALK,
	'Cows_Scantlyn'      => NS_TEMPLATE_TALK,
	'Skantlyn'           => NS_TEMPLATE,
	'Keskows_Skantlyn'   => NS_TEMPLATE_TALK,
	'Cows_Gweres'        => NS_HELP_TALK,
	'Keskows_Gweres'     => NS_HELP_TALK,
	'Cows_Class'         => NS_CATEGORY_TALK,
	'Klass'              => NS_CATEGORY,
	'Keskows_Klass'      => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Allmessages'               => array( 'OllMessajow' ),
	'Allpages'                  => array( 'OllFolennow' ),
	'Ancientpages'              => array( 'FolennowCoth' ),
	'Block'                     => array( 'Lettya' ),
	'Categories'                => array( 'Classys' ),
	'Contributions'             => array( 'Kevrohow' ),
	'Emailuser'                 => array( 'EbostyaDevnydhyer' ),
	'Export'                    => array( 'Esperthy' ),
	'Import'                    => array( 'Ymperthy' ),
	'Movepage'                  => array( 'GwayaFolen' ),
	'Mycontributions'           => array( 'OwHevrohow' ),
	'Mypage'                    => array( 'OwFolen' ),
	'Mytalk'                    => array( 'OwHows' ),
	'Newpages'                  => array( 'FolennowNowyth' ),
	'Preferences'               => array( 'Dewisyansow' ),
	'Randompage'                => array( 'FolenDreJons' ),
	'Recentchanges'             => array( 'Chanjyow_a-dhiwedhes' ),
	'Search'                    => array( 'Whilans' ),
	'Specialpages'              => array( 'FolennowArbennek' ),
	'Upload'                    => array( 'Ughcarga' ),
	'Version'                   => array( 'Versyon' ),
	'Wantedcategories'          => array( 'ClassysWhansus' ),
	'Wantedfiles'               => array( 'RestrennowWhansus' ),
	'Wantedpages'               => array( 'FolennowWhansus' ),
	'Wantedtemplates'           => array( 'ScantlynsWhansus' ),
	'Watchlist'                 => array( 'Rol_golyas' ),
);

$messages = array(
# User preference toggles
'tog-underline'               => 'Islinenna kevrennow:',
'tog-hideminor'               => 'Kudha chanjyow byhan yn chanjyow a-dhiwedhes',
'tog-hidepatrolled'           => 'Kudha chanjyow patrolys yn chanjyow a-dhiwedhes',
'tog-newpageshidepatrolled'   => 'Kudha folennow patrolys dhyworth rol an folennow nowyth',
'tog-extendwatchlist'         => 'Efani an rol wolya dhe dhiskwedhes keniver chanj, a-dar an moyha a-dhiwedhes hepken',
'tog-usenewrc'                => "Bagasa chanjyow herwydh an folen yn chanjyow a-dhiwedhes hag y'n rol wolya (res yw JavaScript)",
'tog-numberheadings'          => 'Awto-nivera pennlinennow',
'tog-showtoolbar'             => 'Diskwedhes an toulvar chanjya (res yw JavaScript)',
'tog-editondblclick'          => 'Chanjya folennow ow tobyl-glyckya (res yw JavaScript)',
'tog-editsection'             => 'Galosegi chanjya trehow der an kevrennow [chanjya]',
'tog-editsectiononrightclick' => 'Galosegi chanjya trehow dre dhyhow-glyckya war ditlys an trehow (res yw JavaScript)',
'tog-rememberpassword'        => "Perthi kov a'm omgelmi war an beurel-ma (rag $1 {{PLURAL:$1|dydh}} dhe'n moyha)",
'tog-watchcreations'          => "Keworra folennow gwruthys genev ha restrennow ughkergys genev dhe'm rol golyas",
'tog-watchdefault'            => "Keworra folennow ha restrennow chanjys genev dhe'm rol golyas",
'tog-watchmoves'              => "Keworra folennow ha restrennow gwayys genev dhe'm rol golyas",
'tog-watchdeletion'           => "Keworra folennow ha restrennow dileys genev dhe'm rol golyas",
'tog-minordefault'            => 'Merkya pub chanj avel byhan dre dhefowt',
'tog-enotifwatchlistpages'    => 'Danvon ebost dhymm pan vo chanjyes folen po restren eus war ow rol wolya',
'tog-enotifusertalkpages'     => 'Danvon ebost dhymm pan vo chanjyes ow folen geskows',
'tog-oldsig'                  => 'Sinans a-lemmyn:',
'tog-fancysig'                => 'Dyghtya an sinans avel wikitekst (heb kevren awtomatek)',
'tog-showjumplinks'           => 'Galosegi kevrennow hedhadowder "lamma dhe"',
'tog-watchlisthideown'        => "Kudha ow chanjyow y'n rol wolya",
'tog-watchlisthidebots'       => "Kudha chanjyow gans bottow y'n rol wolya",
'tog-watchlisthideminor'      => "Kudha chanjyow byhan y'n rol wolya",
'tog-watchlisthideliu'        => "Kudha chanjyow gans devnydhyoryon omgelmys y'n rol wolya",
'tog-watchlisthideanons'      => "Kudha chanjyow gans devnydhyoryon heb hanow y'n rol wolya",
'tog-ccmeonemails'            => 'Danvon dhymm dasskrif a ebostow a dhanvonav dhe dhevnydhyoryon erel',
'tog-showhiddencats'          => 'Diskwedhes klassys kudhys',

'underline-always'  => 'Pub prys',
'underline-never'   => 'Jammes',
'underline-default' => 'Defowt an beurel po an grohen',

# Font style option in Special:Preferences
'editfont-default'   => 'Defowt an beurel',
'editfont-monospace' => 'Font unnspasys',
'editfont-sansserif' => 'Font sans-serif',
'editfont-serif'     => 'Font serif',

# Dates
'sunday'        => "Dy'Sul",
'monday'        => "Dy'Lun",
'tuesday'       => "Dy'Meurth",
'wednesday'     => "Dy'Merher",
'thursday'      => "Dy'Yow",
'friday'        => "Dy'Gwener",
'saturday'      => "Dy'Sadorn",
'sun'           => 'Sul',
'mon'           => 'Lun',
'tue'           => 'Meu',
'wed'           => 'Mer',
'thu'           => 'Yow',
'fri'           => 'Gwe',
'sat'           => 'Sad',
'january'       => 'Genver',
'february'      => 'Hwevrel',
'march'         => 'Meurth',
'april'         => 'Ebrel',
'may_long'      => 'Me',
'june'          => 'Metheven',
'july'          => 'Gortheren',
'august'        => 'Est',
'september'     => 'Gwynngala',
'october'       => 'Hedra',
'november'      => 'Du',
'december'      => 'Kevardhu',
'january-gen'   => 'Genver',
'february-gen'  => 'Hwevrel',
'march-gen'     => 'Meurth',
'april-gen'     => 'Ebrel',
'may-gen'       => 'Me',
'june-gen'      => 'Metheven',
'july-gen'      => 'Gortheren',
'august-gen'    => 'Est',
'september-gen' => 'Gwynngala',
'october-gen'   => 'Hedra',
'november-gen'  => 'Du',
'december-gen'  => 'Kevardhu',
'jan'           => 'Gen',
'feb'           => 'Hwe',
'mar'           => 'Meu',
'apr'           => 'Ebr',
'may'           => 'Me',
'jun'           => 'Met',
'jul'           => 'Gor',
'aug'           => 'Est',
'sep'           => 'Gwy',
'oct'           => 'Hed',
'nov'           => 'Du',
'dec'           => 'Kev',

# Categories related messages
'pagecategories'                 => '{{PLURAL:$1|Klass|Klassys}}',
'category_header'                => 'Folennow y\'n klass "$1"',
'subcategories'                  => 'Isglassys',
'category-media-header'          => 'Media y\'n klass "$1"',
'category-empty'                 => "''Nyns eus na folennow na media y'n class-ma.''",
'hidden-categories'              => '{{PLURAL:$1|Klass kudhys|Klassys kudhys}}',
'hidden-category-category'       => 'Klassys kudhys',
'category-subcat-count'          => "{{PLURAL:$2|Ny'n jeves an klass-ma marnas an isglass a syw.|An klass-ma a'n jeves an {{PLURAL:$1|isglass|$1 isglass}} a syw, dhyworth somm a $2.}}",
'category-subcat-count-limited'  => "An klass-ma a'n jeves an {{PLURAL:$1|isglass|$1 isglass}} a syw.",
'category-article-count'         => "{{PLURAL:$2|Ny'n jeves an klass-ma marnas an folen a syw.|Yma an {{PLURAL:$1|folen|$1 folennow}} a syw y'n klass-ma, dhyworth somm a $2.}}",
'category-article-count-limited' => "Yma an {{PLURAL:$1|folen|$1 folen}} a syw y'n klass-ma.",
'category-file-count'            => "{{PLURAL:$2|Ny'n jeves an klass-ma marnas an restren a syw.|Yma an {{PLURAL:$1|restren|$1 restren}} a syw y'n klass-ma, dhyworth somm a $2.}}",
'category-file-count-limited'    => "Yma an {{PLURAL:$1|folen|$1 folen}} a syw y'n klass-ma.",
'listingcontinuesabbrev'         => 'pes.',

'about'         => 'A-dro dhe',
'article'       => 'Folen dhalgh',
'newwindow'     => '(ygeri yn fenester nowyth)',
'cancel'        => 'Hedhi',
'moredotdotdot' => 'Moy...',
'mypage'        => 'Folen',
'mytalk'        => 'Keskows',
'anontalk'      => 'Keskows rag an drigva IP-ma',
'navigation'    => 'Kevrennow lewya',
'and'           => '&#32;ha(g)',

# Cologne Blue skin
'qbfind'         => 'Kavos',
'qbbrowse'       => 'Peuri',
'qbedit'         => 'Chanjya',
'qbpageoptions'  => 'An folen-ma',
'qbmyoptions'    => 'Ow folennow',
'qbspecialpages' => 'Folennow arbennek',
'faq'            => 'FAQ',

# Vector skin
'vector-action-addsection' => 'Keworra testen',
'vector-action-delete'     => 'Dilea',
'vector-action-move'       => 'Gwaya',
'vector-action-protect'    => 'Difres',
'vector-action-undelete'   => 'Disdhilea',
'vector-action-unprotect'  => 'Chanjya difresans',
'vector-view-create'       => 'Gwruthyl',
'vector-view-edit'         => 'Chanjya',
'vector-view-history'      => 'Gweles an istori',
'vector-view-view'         => 'Redya',
'vector-view-viewsource'   => 'Gweles an bennfenten',
'actions'                  => 'Gwriansow',
'namespaces'               => 'Spasys hanow',
'variants'                 => 'Variennow',

'errorpagetitle'    => 'Gwall',
'returnto'          => 'Dehweles dhe $1.',
'tagline'           => 'Dhyworth {{SITENAME}}',
'help'              => 'Gweres',
'search'            => 'Hwilas',
'searchbutton'      => 'Hwilas',
'go'                => 'Mos',
'searcharticle'     => 'Mos',
'history'           => 'Istori an folen',
'history_short'     => 'Istori',
'updatedmarker'     => 'nowedhys a-dhia ow vysytyans diwettha',
'printableversion'  => 'Versyon pryntyadow',
'permalink'         => 'Kevren fast',
'print'             => 'Pryntya',
'view'              => 'Gweles',
'edit'              => 'Chanjya',
'create'            => 'Gwruthyl',
'editthispage'      => 'Chanjya an folen-ma',
'create-this-page'  => 'Gwruthyl an folen-ma',
'delete'            => 'Dilea',
'deletethispage'    => 'Dilea an folen-ma',
'undelete_short'    => 'Disdhilea {{PLURAL:$1|unn janj|$1 chanj}}',
'viewdeleted_short' => 'Gweles {{PLURAL:$1|unn janj diles|$1 chanj diles}}',
'protect'           => 'Difres',
'protect_change'    => 'chanjya',
'protectthispage'   => 'Difres an folen-ma',
'unprotect'         => 'Chanjya difresans',
'unprotectthispage' => 'Chanjya difresans an folen-ma',
'newpage'           => 'Folen nowyth',
'talkpage'          => "Dadhlow a'n folen-ma",
'talkpagelinktext'  => 'keskows',
'specialpage'       => 'Folen arbennek',
'personaltools'     => 'Toulys personel',
'postcomment'       => 'Tregh nowyth',
'articlepage'       => 'Gweles an folen',
'talk'              => 'Keskows',
'views'             => 'Gwelyansow',
'toolbox'           => 'Toulgist',
'userpage'          => 'Gweles an folen dhevnydhyer',
'projectpage'       => 'Gweles folen an ragdres',
'imagepage'         => 'Gweles folen an restren',
'mediawikipage'     => 'Gweles folen an messajys',
'templatepage'      => 'Gweles folen an skantlyn',
'viewhelppage'      => 'Gweles an folen weres',
'categorypage'      => 'Gweles folen an klass',
'viewtalkpage'      => 'Gweles an dadhlow',
'otherlanguages'    => 'Yn yethow erel',
'redirectedfrom'    => '(Daskedyes dhyworth $1)',
'redirectpagesub'   => 'Folen dhaskedya',
'lastmodifiedat'    => 'Diwettha chanj an folen-ma o an $1, dhe $2.',
'protectedpage'     => 'Folen dhifresys',
'jumpto'            => 'Lamma dhe:',
'jumptonavigation'  => 'kevrennow lewya',
'jumptosearch'      => 'hwilas',
'view-pool-error'   => 'Drog yw genen, gorgergys yw an servyers orth an termyn-ma.
Yma re a dhevnydhyoryon owth assaya gweles an folen-ma.
Gortewgh pols kyns hwi dhe assaya hedhas an folen-ma arta, mar pleg.

$1',
'pool-errorunknown' => 'Gwall ankoth',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite'            => 'A-dro dhe {{SITENAME}}',
'aboutpage'            => 'Project:Kedhlow',
'copyright'            => 'Kavadow yw an dalgh yn-dann $1.',
'copyrightpage'        => '{{ns:project}}:Gwirbryntyansow',
'currentevents'        => 'Hwarvosow a-lemmyn',
'currentevents-url'    => 'Project:Hwarvosow a-lemmyn',
'disclaimers'          => 'Avisyansow',
'disclaimerpage'       => 'Project:Avisyans ollgemmyn',
'edithelp'             => 'Gweres gans chanjya',
'edithelppage'         => 'Help:Chanjya',
'helppage'             => 'Help:Gweres',
'mainpage'             => 'Dynnargh',
'mainpage-description' => 'Dynnargh',
'policy-url'           => 'Project:Polici',
'portal'               => 'Porth an gemeneth',
'portal-url'           => 'Project:Porth an gemeneth',
'privacy'              => 'Polici privetter',
'privacypage'          => 'Project:Polici privetter',

'badaccess' => 'Gwall kummyes',

'ok'                      => 'Sur',
'retrievedfrom'           => 'Daskevys dhyworth "$1"',
'youhavenewmessages'      => "$1 a'gas beus ($2).",
'newmessageslink'         => 'Messajys nowyth',
'newmessagesdifflink'     => 'chanj diwettha',
'youhavenewmessagesmulti' => "Messajys nowyth a'gas beus war $1",
'editsection'             => 'chanjya',
'editold'                 => 'chanjya',
'viewsourceold'           => 'gweles an bennfenten',
'editlink'                => 'chanjya',
'viewsourcelink'          => 'gweles an bennfenten',
'editsectionhint'         => 'Chanjya an tregh: $1',
'toc'                     => 'Rol an folen',
'showtoc'                 => 'diskwedhes',
'hidetoc'                 => 'kudha',
'collapsible-expand'      => 'Efani',
'thisisdeleted'           => 'Gweles po daskor $1?',
'viewdeleted'             => 'Gweles $1?',
'restorelink'             => '{{PLURAL:$1|unn janj diles|$1 chanj diles}}',
'feedlinks'               => 'Feed:',
'site-rss-feed'           => 'Feed RSS $1',
'site-atom-feed'          => 'Feed Atom $1',
'page-rss-feed'           => 'Feed RSS "$1"',
'page-atom-feed'          => 'Feed Atom "$1"',
'red-link-title'          => '$1 (nyns eus folen henwys yndelma)',

# Short words for each namespace, by default used in the namespace tab in monobook
'nstab-main'      => 'Folen',
'nstab-user'      => 'Folen dhevnydhyer',
'nstab-media'     => 'Folen media',
'nstab-special'   => 'Folen arbennek',
'nstab-project'   => 'Folen ragdres',
'nstab-image'     => 'Restren',
'nstab-mediawiki' => 'Messach',
'nstab-template'  => 'Skantlyn',
'nstab-help'      => 'Gweres',
'nstab-category'  => 'Klass',

# General errors
'error'               => 'Gwall',
'databaseerror'       => 'Gwall database',
'readonly'            => 'Alhwedhys yw an database',
'missingarticle-rev'  => '(amendyans#: $1)',
'missingarticle-diff' => '(Dyffrans: $1, $2)',
'internalerror'       => 'Gwall a-bervedh',
'internalerror_info'  => 'Gwall a-bervedh: $1',
'filecopyerror'       => 'Ny allas kopia an restren "$1" dhe "$2".',
'filerenameerror'     => 'Ny allas dashenwel an restren "$1" dhe "$2".',
'filedeleteerror'     => 'Ny allas dilea an restren "$1".',
'filenotfound'        => 'Ny allas kavos an restren "$1".',
'cannotdelete-title'  => 'Ny yllir dilea an folen "$1"',
'badtitle'            => 'Titel drog',
'viewsource'          => 'Gweles an bennfenten',
'viewsource-title'    => 'Gweles an bennfenten rag $1',
'protectedpagetext'   => 'Difresys re beu an folen-ma rag gwitha rag chanjya po gwriansow erel.',
'viewsourcetext'      => 'Hwi a yll gweles ha kopia pennfenten an folen-ma:',
'ns-specialprotected' => 'Ny yllir chanjya folennow arbennek.',

# Login and logout pages
'welcomecreation'          => '== Dynnargh, $1! ==
Gwruthys yw agas acont.
Na wrewgh ankevy dhe janjya agas [[Special:Preferences|dowisyansow {{SITENAME}}]].',
'yourname'                 => 'Hanow devnydhyer:',
'yourpassword'             => 'Ger tremena:',
'yourpasswordagain'        => 'Jynnskrifewgh agas ger tremena arta:',
'remembermypassword'       => "Perthi kov a'm omgelmi war an jynn amontya-ma (rag $1 {{PLURAL:$1|dydh}} dhe'n moyha)",
'securelogin-stick-https'  => 'Gwitha junyes gans HTTPS wosa omgelmi',
'yourdomainname'           => 'Agas tiredh:',
'login'                    => 'Omgelmi',
'nav-login-createaccount'  => 'Omgelmi / Gwruthyl akont nowyth',
'loginprompt'              => 'Res yw dhywgh galosegi cookies rag omgelmi orth {{SITENAME}}.',
'userlogin'                => 'Omgelmi / gwruthyl akont nowyth',
'userloginnocreate'        => 'Omgelmi',
'logout'                   => 'Digelmi',
'userlogout'               => 'Digelmi',
'notloggedin'              => 'Digelmys',
'nologin'                  => "A ny'gas beus akont? '''$1'''.",
'nologinlink'              => 'Gwruthyl akont',
'createaccount'            => 'Gwruthyl akont nowyth',
'gotaccount'               => "Eus akont dhywgh seulabrys? '''$1'''.",
'gotaccountlink'           => 'Omgelmi',
'userlogin-resetlink'      => 'A ankevsowgh hwi agas manylyon omgelmi?',
'createaccountmail'        => 'der e-bost',
'createaccountreason'      => 'Acheson:',
'badretype'                => 'Ny omdhesedh an geryow tremena entrys genowgh.',
'userexists'               => 'Y tevnydhir an hanow devnydhyer entrys genowgh seulabrys.
Dewisewgh ken hanow mar pleg.',
'loginerror'               => 'Gwall omgelmi',
'createaccounterror'       => 'Ny allas gwruthyl an akont: $1',
'nocookiesnew'             => "Gwruthys veu an akont, mes nyns owgh omgelmys.
{{SITENAME}} a dhevnydh cookies rag omgelmi devnydhyoryon.
Dialosegys yw cookies war agas jynn amontya.
Galosegewgh i, hag omgelmewgh der agas hanow devnydhyer ha'gas ger tremena nowyth.",
'nocookieslogin'           => '{{SITENAME}} a dhevnydh cookies rag omgelmi devnydhyoryon.
Dialosegys yw cookies war agas jynn amontya.
Galosegewgh i hag assayewgh arta.',
'noname'                   => 'Ny resowgh hanow devnydhyer da.',
'loginsuccesstitle'        => 'Omgelmi a sewenis',
'loginsuccess'             => "'''Omgelmys owgh lemmyn orth {{SITENAME}} avel \"\$1\".'''",
'nouserspecified'          => 'Res yw dhywgh ri hanow devnydhyer.',
'wrongpassword'            => 'Kamm o an ger tremena.
Assayewgh arta mar pleg.',
'wrongpasswordempty'       => 'Gwag o an ger tremena res.
Assayewgh arta mar pleg.',
'passwordtooshort'         => "Res yw dhe eryow tremena bos {{PLURAL:$1|1 lytheren|$1 lytheren}} dhe'n lyha.",
'password-name-match'      => "Ny yll agas ger tremena bos an keth ha'gas hanow devnydhyer.",
'password-login-forbidden' => 'Difennys yw devnydhya an hanow devnydhyer-ma hag an ger tremena-ma.',
'mailmypassword'           => 'Ebostya ger tremena nowyth',
'passwordremindertitle'    => 'Ger tremena nowyth rag {{SITENAME}}',
'passwordremindertext'     => 'Nebonan (hwi martesen, dhyworth an drigva IP $1) a wovynnis ger tremena nowyth rag {{SITENAME}} ($4). Ger tremena anbarthus rag an devnydhyer
"$2" re beu gwruthys hag a veu settyes dhe "$3". Mars o henna agas bodh, y fydh res dhywgh omgelmi ha dewis ger tremena nowyth lemmyn.
Agas ger tremena anbarthus a dhiwedh yn {{PLURAL:$5|unn jydh|$5 dydh}}.

Mar kovynnis nebonan aral hemma, po hwi a\'gas beus kov a\'gas ger tremena ha ny\'m beus hwans dh\'y janjya namoy, hwi a yll skonya aswon an messach-ma ha pesya devnydhya agas ger tremena koth.',
'noemail'                  => 'Nyns eus trigva ebost rekordys rag an devnydhyer "$1".',
'noemailcreate'            => 'Res yw dhywgh ri trigva ebost da',
'passwordsent'             => 'Ger tremena nowyth re beu danvenys dhe\'n drigva ebost kovskrifys rag "$1".
Omgelmewgh arta mar pleg wosa hwi dh\'y receva.',
'emailauthenticated'       => 'Afydhyes veu agas trigva ebost an $2 dhe $3.',
'emailconfirmlink'         => 'Afydhyewgh agas trigva ebost',
'invalidemailaddress'      => 'Ny yllir alowa an drigva ebost drefen bos furvyans drog dhedhi.
Entrewgh trigva da y furvyans po gwakhewgh an furvlen-na.',
'accountcreated'           => 'Akont gwruthys',
'accountcreatedtext'       => 'Gwruthys re beu an akont rag $1.',
'createaccount-title'      => 'Gwruthyl akont rag {{SITENAME}}',
'createaccount-text'       => 'Nebonan a wrug akont rag agas trigva ebost war {{SITENAME}} ($4) henwys "$2", "$3" y er tremena.
Y talvia dhywgh omgelmi ha chanjya agas ger tremena lemmyn.

Hwi a yll skonya aswon an messach-ma mar peu an akont-ma gwruthys yn gwall.',
'usernamehasherror'        => 'Ny yllir bos lytherennow hash yn henwyn devnydhyer',
'loginlanguagelabel'       => 'Yeth: $1',

# Change password dialog
'resetpass'                 => 'Chanjya ger tremena',
'resetpass_announce'        => 'Hwi a omgelmis dre goden ebostyes anbarthus.
Rag gorfenna omgelmi, res yw dhywgh settya ger tremena nowyth omma:',
'resetpass_header'          => 'Chanjya ger tremena an akont',
'oldpassword'               => 'Ger tremena koth:',
'newpassword'               => 'Ger tremena nowyth:',
'retypenew'                 => 'Jynnscrifewgh an ger tremena nowyth arta:',
'resetpass_submit'          => 'Settya an ger tremena hag omgelmi',
'resetpass_success'         => 'Chanjyes re beu agas ger tremena yn soweny!
Orth agas omgelmy lemmyn...',
'resetpass_forbidden'       => 'Ny yllir chanjya geryow tremena',
'resetpass-submit-loggedin' => 'Chanjya an ger tremena',
'resetpass-submit-cancel'   => 'Hedhi',
'resetpass-temp-password'   => 'Ger tremena anbarthus:',

# Special:PasswordReset
'passwordreset'                   => 'Dassettya an ger tremena',
'passwordreset-text'              => 'Lenwewgh an furvlen-ma rag dassettya agas ger tremena.',
'passwordreset-legend'            => 'Dassettya an ger tremena',
'passwordreset-disabled'          => 'Dialosegys yw dassettya geryow tremena war an wiki-ma.',
'passwordreset-pretext'           => "{{PLURAL:$1||Entrowgh onen a'n tymmyn a dhata a-woles}}",
'passwordreset-username'          => 'Hanow devnydhyer:',
'passwordreset-domain'            => 'Tiredh:',
'passwordreset-email'             => 'Trigva ebost:',
'passwordreset-emailtitle'        => 'Manylyon agas akont war {{SITENAME}}',
'passwordreset-emailsent'         => 'Ebost dassettya ger tremena re beu danvenys.',
'passwordreset-emailsent-capture' => 'Ebost dassettya ger tremena re beu danvenys, hag y hyllir y weles a-woles.',

# Special:ChangeEmail
'changeemail'          => 'Chanjya trigva ebost',
'changeemail-header'   => 'Chanjya trigva ebost an akont',
'changeemail-text'     => 'Lenwewgh an furvlen-ma rag chanjya agas trigva ebost. Y fydh res dhywgh entra agas ger tremena rag afydhya an chanj-ma.',
'changeemail-oldemail' => 'Agas trigva ebost a-lemmyn:',
'changeemail-newemail' => 'Agas trigva ebost nowyth:',
'changeemail-none'     => '(nagonan)',
'changeemail-submit'   => 'Chanjya an trigva ebost',
'changeemail-cancel'   => 'Hedhi',

# Edit page toolbar
'bold_sample'     => 'Tekst tew',
'bold_tip'        => 'Tekst tew',
'italic_sample'   => 'Tekst italek',
'italic_tip'      => 'Tekst italek',
'link_sample'     => 'Titel an gevren',
'link_tip'        => 'Kevren bervedhel',
'extlink_sample'  => 'http://www.example.com titel an gevren',
'extlink_tip'     => 'Kevren a-ves (na ankevewgh an rager http://)',
'headline_sample' => 'Tekst an bennlinen',
'headline_tip'    => 'Pennlinen nivel 2',
'nowiki_sample'   => 'Keworrewgh tekst heb furvyans omma',
'nowiki_tip'      => 'Skonya aswon furvyans wiki',
'image_tip'       => 'Restren neythys',
'media_tip'       => 'Kevren restren',
'sig_tip'         => 'Agas sinans gans stampa-termyn',

# Edit pages
'summary'                          => 'Berrskrif:',
'subject'                          => 'Testen/Pennlinen:',
'minoredit'                        => 'Chanj byhan yw hemma',
'watchthis'                        => 'Golya an folen-ma',
'savearticle'                      => 'Gwitha an folen',
'preview'                          => 'Ragwel',
'showpreview'                      => 'Diskwedhes ragwel',
'showlivepreview'                  => 'Ragwel byw',
'showdiff'                         => 'Diskwedhes an chanjyow',
'anoneditwarning'                  => "'''Gwarnyans:''' Nyns owgh omgelmys.
Rekordys vydh agas trigva IP yn istori an folen-ma.",
'anonpreviewwarning'               => "''Nyns owgh omgelmys. Dre witha, agas trigva IP a vydh rekordyes istori chanjya an folen-ma.''",
'summary-preview'                  => "Ragwel a'n berrskrif:",
'loginreqtitle'                    => 'Res yw omgelmi',
'loginreqlink'                     => 'omgelmi',
'accmailtitle'                     => 'Ger-tremena danvenys.',
'newarticle'                       => '(Nowyth)',
'newarticletext'                   => "Hwi re holyas kevren dhe folen nag yw gwruthys hwath.
Rag gwruthyl an folen, dalethewgh jynnskrifa y'n gist a-woles (gwelewgh an [[{{MediaWiki:Helppage}}|folen weres]] rag moy kedhlow).
Mar teuthowgh omma yn kamm, klyckyewgh boton '''war-dhelergh''' agas peurel.",
'noarticletext'                    => 'Nyns eus tekst y\'n folen-ma a-lemmyn.
Hwi a yll [[Special:Search/{{PAGENAME}}|hwilas titel an folen-ma]] yn folennow erel,
<span class="plainlinks">[{{fullurl:{{#Special:Log}}|page={{FULLPAGENAMEE}}}} hwilas y\'n kovnotennow kelmys],
po [{{fullurl:{{FULLPAGENAME}}|action=edit}} chanjya an folen-ma]</span>.',
'userpage-userdoesnotexist'        => 'Nyns yw kovskrifys an akont devnydhyer "$1".
Checkyewgh mar pleg mara\'gas beus hwans dhe wruthyl/dhe janjya an folen-ma.',
'userpage-userdoesnotexist-view'   => 'Nyns yw kovskrifys an akont devnydhyer "$1".',
'updated'                          => '(Nowedhys)',
'note'                             => "'''Noten:'''",
'previewnote'                      => "Perthewgh kov, nyns yw hemma marnas ragwel.''' Nyns yw gwithys agas chanjyow hwath!",
'editing'                          => 'Ow chanjya $1',
'editingsection'                   => 'Ow chanjya $1 (tregh)',
'editingcomment'                   => 'Ow chanjya $1 (tregh nowyth)',
'yourtext'                         => 'Agas tekst',
'yourdiff'                         => 'Dyffransow',
'protectedpagewarning'             => "'''Gwarnyans: An folen-ma re beu difresys rag ma nag allo marnas devnydhyoryon gans gwiryow menystrer hy chanjya.'''
Res yw an diwettha kovnoten a-woles rag godhvos:",
'templatesused'                    => '{{PLURAL:$1|An skantlyn|Skantlyns}} devnydhys war an folen-ma:',
'templatesusedpreview'             => "{{PLURAL:$1|An skantlyn|Skantlyns}} devnydhys y'n ragwel-ma:",
'template-protected'               => '(difresys)',
'template-semiprotected'           => '(hanter-difresys)',
'hiddencategories'                 => 'Esel a {{PLURAL:$1|1 glass kudhys|$1 klass kudhys}} yw an folen-ma:',
'permissionserrorstext-withaction' => "Ny'gas beus kummyes dhe $2, rag an {{PLURAL:$1|acheson|achesonys}} a syw:",
'moveddeleted-notice'              => 'An folen-ma re beu diles.
Yma kovnoten dhilea ha gwaya an folen res a-woles.',
'log-fulllog'                      => 'Gweles an govnoten dhien',

# "Undo" feature
'undo-success' => 'Y hyllir diswul an chanj-ma.
Checkyewgh mar pleg an kehevelyans a-woles rag gwirya bos hemma an pyth a vynnowgh, hag ena gwithewgh an chanjyow a-woles rag gorfenna diswul an chanj.',
'undo-summary' => 'Amendyans $1 gans [[Special:Contributions/$2|$2]] ([[User talk:$2|keskows]]) diswrys',

# Account creation failure
'cantcreateaccounttitle' => 'Ny yllir gwruthyl an akont',

# History pages
'viewpagelogs'           => 'Gweles kovnotennow an folen-ma',
'currentrev'             => 'Amendyans diwettha',
'currentrev-asof'        => 'An amendyans diwettha a-dhia $1',
'revisionasof'           => 'Versyon an folen a-dhia $1',
'revision-info'          => 'Amendyans a-dhia $1 gans $2',
'previousrevision'       => '??? Amendyans kottha',
'nextrevision'           => 'Amendyans nowyttha ???',
'currentrevisionlink'    => 'An amendyans diwettha',
'cur'                    => 'lemmyn',
'next'                   => 'nessa',
'last'                   => 'kyns',
'page_first'             => 'kynsa',
'page_last'              => 'diwettha',
'histlegend'             => "Dewis dyffransow: Merkyewgh kistennow radyo a'n amendyansow dhe geheveli, ha gweskewgh 'entra' po an boton orth goles an folen.<br />
Alhwedh: '''({{int:cur}})''' = an dyffrans dhyworth an amendyans diwettha, '''({{int:last}})''' = an dyffrans dhyworth an amendyans kyns, '''{{int:minoreditletter}}''' = chanj byhan.",
'history-fieldset-title' => 'Peuri an istori',
'history-show-deleted'   => 'Diles hepken',
'histfirst'              => 'An moyha a-varr',
'histlast'               => 'An diwettha',
'historysize'            => '({{PLURAL:$1|1 bayt}})',
'historyempty'           => '(gwag)',

# Revision feed
'history-feed-title'          => 'Istori amendya',
'history-feed-description'    => 'Istori amendya rag an folen-ma war an wiki',
'history-feed-item-nocomment' => '$1 dhe $2',

# Revision deletion
'rev-delundel'           => 'diskwedhes/kudha',
'rev-showdeleted'        => 'diskwedhes',
'revdel-restore'         => 'chanjya an hewelder',
'revdel-restore-deleted' => 'amendyansow diles',
'revdel-restore-visible' => 'amendyansow gweladow',
'pagehist'               => 'Istori an folen',

# History merging
'mergehistory-reason' => 'Acheson:',

# Merge log
'revertmerge' => 'Diswul an kesunya',

# Diffs
'history-title'            => 'Istori an folen "$1"',
'difference'               => '(Dyffrans ynter an amendyansow)',
'difference-multipage'     => '(Dyffrans ynter an folennow)',
'lineno'                   => 'Linen $1:',
'compareselectedversions'  => 'Keheveli an amendyansow dewisyes',
'showhideselectedversions' => 'Diskwedhes/kudha amendyansow dewisyes',
'editundo'                 => 'diswul',

# Search results
'searchresults'                    => 'Sewyansow an hwilans',
'searchresults-title'              => 'Sewyansow an hwilans rag "$1"',
'searchresulttext'                 => 'Rag moy kedhlow a-dro dhe hwilas yn {{SITENAME}}, gwelewgh [[{{MediaWiki:Helppage}}|{{int:help}}]].',
'searchsubtitle'                   => 'Hwi a hwilas \'\'\'[[:$1]]\'\'\' ([[Special:Prefixindex/$1|keniver folen ow talleth gans "$1"]]{{int:pipe-separator}}[[Special:WhatLinksHere/$1|keniver folen ow kevrenna dhe "$1"]])',
'searchsubtitleinvalid'            => "Hwi a hwilas '''$1'''",
'notitlematches'                   => 'Nyns eus titel folen vyth owth omdhesedha',
'notextmatches'                    => 'Nyns eus tekst folen vyth owth omdhesedha',
'prevn'                            => '{{PLURAL:$1|$1}} kyns',
'nextn'                            => 'nessa {{PLURAL:$1|$1}}',
'prevn-title'                      => '$1 {{PLURAL:$1|sewyans}} kyns',
'nextn-title'                      => '$1 {{PLURAL:$1|sewyans}} nessa',
'shown-title'                      => 'Diskwedhes $1 {{PLURAL:$1|sewyans}} yn folen',
'viewprevnext'                     => 'Gweles ($1 {{int:pipe-separator}} $2) ($3)',
'searchmenu-legend'                => 'Etholyow hwilas',
'searchmenu-exists'                => "''Yma folen henwys \"[[:\$1]]\" war an wiki-ma'''",
'searchmenu-new'                   => "'''Gwruthyl an folen \"[[:\$1]]\" war an wiki-ma!'''",
'searchhelp-url'                   => 'Help:Gweres',
'searchprofile-articles'           => 'Folennow dalgh',
'searchprofile-project'            => 'Folennow gweres ha ragdres',
'searchprofile-images'             => 'Liesmedia',
'searchprofile-everything'         => 'Puptra',
'searchprofile-advanced'           => 'Avonsys',
'searchprofile-articles-tooltip'   => 'Hwilas yn $1',
'searchprofile-project-tooltip'    => 'Hwilas yn $1',
'searchprofile-images-tooltip'     => 'Hwilas restrennow',
'searchprofile-everything-tooltip' => 'Hwilas pub le (yn folennow keskows ynwedh)',
'searchprofile-advanced-tooltip'   => 'Hwilas yn spasys hanow personelhes',
'search-result-size'               => '$1 ({{PLURAL:$2|1 ger|$2 ger}})',
'search-result-category-size'      => '{{PLURAL:$1|1 esel|$1 esel}} ({{PLURAL:$2|1 isglass|$2 isglass}}, {{PLURAL:$3|1 restren|$3 restren}})',
'search-redirect'                  => '(daskedyans $1)',
'search-section'                   => '(tregh $1)',
'search-suggest'                   => 'A styrsowgh hwi: $1',
'search-interwiki-caption'         => 'Ragdresow hwor',
'search-interwiki-default'         => '$1 sewyansow:',
'search-interwiki-more'            => '(moy)',
'search-mwsuggest-enabled'         => 'gans profyansow',
'search-mwsuggest-disabled'        => 'heb profyansow',
'search-relatedarticle'            => 'Kelmys',
'mwsuggest-disable'                => 'Dialosegi profyansow hwilas',
'searcheverything-enable'          => 'Hwilas yn pub spas-hanow',
'searchrelated'                    => 'kelmys',
'searchall'                        => 'oll',
'showingresultsheader'             => "{{PLURAL:$5|Sewyans '''$1''' a '''$3'''|Sewyansow '''$1 - $2''' a '''$3'''}} rag '''$4'''",
'nonefound'                        => "'''Noten''': Ny hwilir marnas yn rann a'n spasys-hanow dre dhefowt.
Assayewgh rag-gorra agas govyn gans ''all:'' rag hwilas yn pub tyller (ynna an folennow keskows, skantlyns, etc), po devnydhyewgh an spas-hanow hwensys avel rag-gorrans.",
'search-nonefound'                 => 'Nyns esa sewyans vyth owth omdhesedha orth an govyn.',
'powersearch'                      => 'Hwilans avonsys',
'powersearch-legend'               => 'Hwilans avonsys',
'powersearch-ns'                   => 'Hwilas yn spasys-hanow:',
'powersearch-redir'                => 'Rolya daskedyansow',
'powersearch-field'                => 'Hwilas',
'powersearch-togglelabel'          => 'Dewis:',
'powersearch-toggleall'            => 'Oll',
'powersearch-togglenone'           => 'Nagonan',
'search-external'                  => 'Hwilans a-ves',

# Preferences page
'preferences'                 => 'Dewisyansow',
'mypreferences'               => 'Dewisyansow',
'prefs-edits'                 => 'Niver a janjyow:',
'changepassword'              => 'Chanjya an ger-tremena',
'prefs-skin'                  => 'Krohen',
'skin-preview'                => 'Ragweles',
'prefs-datetime'              => 'Dedhyans hag eur',
'prefs-personal'              => 'Profil devnydhyer',
'prefs-rc'                    => 'Chanjyow a-dhiwedhes',
'prefs-watchlist'             => 'Rol wolya',
'prefs-watchlist-days'        => "Niver a dhedhyow dhe dhiskwedhes y'n rol wolya:",
'prefs-resetpass'             => 'Chanjya an ger tremena',
'prefs-changeemail'           => 'Chanjya an drigva ebost',
'prefs-setemail'              => 'Settya trigva ebost',
'prefs-email'                 => 'Etholyow ebostya',
'saveprefs'                   => 'Gwitha',
'resetprefs'                  => 'Klerhe chanjyow nag yw gwithys',
'restoreprefs'                => 'Restorya pub settyans defowt',
'prefs-editing'               => 'Chanjya',
'prefs-edit-boxsize'          => 'Myns an fenester janjya.',
'rows'                        => 'Rewyow:',
'columns'                     => 'Kolovennow:',
'searchresultshead'           => 'Hwilas',
'savedprefs'                  => 'Gwithys re beu agas dewisyansow.',
'servertime'                  => 'Eur an servyer:',
'guesstimezone'               => 'Lenwel dhyworth an beurel',
'timezoneregion-africa'       => 'Afrika',
'timezoneregion-america'      => 'Amerika',
'timezoneregion-antarctica'   => 'Antarktika',
'timezoneregion-arctic'       => 'Arktek',
'timezoneregion-asia'         => 'Asi',
'timezoneregion-atlantic'     => 'Keynvor Atlantek',
'timezoneregion-australia'    => 'Ostrali',
'timezoneregion-europe'       => 'Europa',
'timezoneregion-indian'       => 'Keynvor Eyndek',
'timezoneregion-pacific'      => 'Keynvor Hebask',
'allowemail'                  => 'Galosegi ebost dhyworth devnydhyoryon erel',
'prefs-searchoptions'         => 'Hwilas',
'prefs-files'                 => 'Restrennow',
'prefs-emailconfirm-label'    => 'Afydhyans an ebost:',
'youremail'                   => 'Ebost:',
'username'                    => 'Hanow-usyer:',
'uid'                         => 'ID devnydhyer:',
'prefs-memberingroups'        => "Esel a'n {{PLURAL:$1|bagas|bagasow}}:",
'prefs-registration'          => 'Termyn kovskrifa:',
'yourrealname'                => 'Hanow gwir:',
'yourlanguage'                => 'Yeth:',
'yournick'                    => 'Sinans nowyth:',
'prefs-help-signature'        => 'Y tal sina kampolansow war folennow keskows gans "<nowiki>~~~~</nowiki>", a dreylir dhe\'gas sinans ha dhe stamp-termyn.',
'yourgender'                  => 'Reydh:',
'gender-unknown'              => 'Heb hy disklosya',
'gender-male'                 => 'Gorow',
'gender-female'               => 'Benow',
'email'                       => 'Ebost',
'prefs-help-email'            => 'A-dhewis yw ri trigva ebost, mes res yw  rag dassettya agas ger tremena mar po ankevys.',
'prefs-help-email-others'     => 'Hwi a yll dewis gasa dhe re erel kestava dhywgh der ebost dre glyckya kevren war agas folen dhevnydhyer po folen geskows.
Ny dhiskwedhir agas trigva ebost pan gestaffo devnydhyoryon erel dhywgh.',
'prefs-help-email-required'   => 'Res yw trigva ebost.',
'prefs-info'                  => 'Kedhlow selvenel',
'prefs-i18n'                  => 'Keswlasegyans',
'prefs-signature'             => 'Sinans',
'prefs-advancedediting'       => 'Etholyow avonsys',
'prefs-advancedrc'            => 'Etholyow avonsys',
'prefs-advancedrendering'     => 'Etholyow avonsys',
'prefs-advancedsearchoptions' => 'Etholyow avonsys',
'prefs-advancedwatchlist'     => 'Etholyow avonsys',
'prefs-displayrc'             => 'Etholyow diskwedhes',
'prefs-displaysearchoptions'  => 'Etholyow diskwedhes',
'prefs-displaywatchlist'      => 'Etholyow diskwedhes',

# User rights
'userrights-user-editname' => 'Entrewgh hanow devnydhyer:',
'userrights-groupsmember'  => 'Esel a:',
'userrights-reason'        => 'Acheson:',

# Groups
'group'               => 'Bagas:',
'group-user'          => 'Devnydhyoryon',
'group-autoconfirmed' => 'Devnydhyoryon awto-afydhyes',
'group-bot'           => 'Bottow',
'group-sysop'         => 'Menystroryon',
'group-all'           => '(oll)',

'group-user-member'  => '{{GENDER:$1|Devnydhyer}}',
'group-bot-member'   => '{{GENDER:$1|bott}}',
'group-sysop-member' => '{{GENDER:$1|menystrer}}',

'grouppage-user'  => '{{ns:project}}:Devnydhyoryon',
'grouppage-bot'   => '{{ns:project}}:Bottow',
'grouppage-sysop' => '{{ns:project}}:Menystroryon',

# Rights
'right-read'          => 'Redya folennow',
'right-edit'          => 'Chanjya folennow',
'right-createtalk'    => 'Gwruthyl folennow keskows',
'right-createaccount' => 'Gwruthyl akontow devnydhyer nowyth',
'right-move'          => 'Gwaya folennow',
'right-movefile'      => 'Gwaya restrennow',
'right-upload'        => 'Ughkarga restrennow',
'right-delete'        => 'Dilea folennow',

# User rights log
'rightslog' => 'Kovnoten wiryow an devnydhyer',

# Associated actions - in the sentence "You do not have permission to X"
'action-edit'     => 'chanjya an folen-ma',
'action-move'     => 'gwaya an folen-ma',
'action-movefile' => 'gwaya an restren-ma',
'action-upload'   => 'ughkarga an restren-ma',
'action-delete'   => 'dilea an folen-ma',

# Recent changes
'nchanges'                        => '$1 {{PLURAL:$1|chanj|chanj}}',
'recentchanges'                   => 'Chanjyow a-dhiwedhes',
'recentchanges-legend'            => 'Etholyow an chanjyow a-dhiwedhes',
'recentchangestext'               => "War'n folen-ma y hellowgh hwi sewya an chanjyow diwettha eus gwres dhe'n wiki.",
'recentchanges-feed-description'  => "Y hyllir helerhi an chanjyow diwettha gwrys dhe'n wiki y'n feed-ma.",
'recentchanges-label-newpage'     => 'Y feu gwruthys folen nowyth gans an chanj-ma',
'recentchanges-label-minor'       => 'Chanj byhan yw hemma',
'recentchanges-label-bot'         => 'Gwrys veu an chanj-ma gans bott',
'recentchanges-label-unpatrolled' => 'Ny veu an chanj-ma patrolyes hwath',
'rcnote'                          => "A-woles yma {{PLURAL:$1|'''1''' janj|an '''$1''' chanjyow diwettha}} y'n {{PLURAL:$2|dydh|'''$2''' dydh}} diwettha, a-dhia $5, $4.",
'rclistfrom'                      => 'Diskwedhes chanjyow nowyth yn unn dhalleth dhyworth $1.',
'rcshowhideminor'                 => '$1 chanjyow byhan',
'rcshowhidebots'                  => '$1 bottow',
'rcshowhideliu'                   => '$1 devnydhoryon omgelmys',
'rcshowhideanons'                 => '$1 devnydhyoryon dhihanow',
'rcshowhidemine'                  => '$1 ow chanjyow',
'rclinks'                         => "Diskwedhes an $1 chanj diwettha gwrys y'n $2 dydh diwettha<br />$3",
'diff'                            => 'dyffrans',
'hist'                            => 'istori',
'hide'                            => 'Kudha',
'show'                            => 'Diskwedhes',
'minoreditletter'                 => 'B',
'newpageletter'                   => 'N',
'boteditletter'                   => 'bott',
'newsectionsummary'               => '/* $1 */ tregh nowyth',
'rc-enhanced-expand'              => 'Diskwedhes an manylyon (res yw JavaScript)',
'rc-enhanced-hide'                => 'Kudha an manylyon',

# Recent changes linked
'recentchangeslinked'          => 'Chanjyow kelmys',
'recentchangeslinked-feed'     => 'Chanjyow kelmys',
'recentchangeslinked-toolbox'  => 'Chanjyow kelmys',
'recentchangeslinked-title'    => 'Chanjyow kelmys dhe "$1"',
'recentchangeslinked-noresult' => 'Nyns esa chanj vyth war folennow kevrennys dres an termyn res.',
'recentchangeslinked-summary'  => "Homm yw rol a janjyow gwrys a-dhiwedhes dhe folennow yw kevrennys dhyworth folen res (po dhe eseli a glass res).
'''Tew''' yw folennow eus war agas [[Special:Watchlist|rol wolya]].",
'recentchangeslinked-page'     => 'Hanow an folen:',
'recentchangeslinked-to'       => "Diskwedhes chanjyow dhe folennow kevrennys dhe'n folen res yn le",

# Upload
'upload'            => 'Ughkarga restren',
'uploadbtn'         => 'Ughkarga restren',
'reuploaddesc'      => "Hedhi ughkarga ha dehweles dhe'n furvlen ughkarga",
'uploadnologin'     => 'Digelmys',
'uploadnologintext' => 'Res yw bos [[Special:UserLogin|omgelmys]] rag ughcarga restrennow.',
'uploaderror'       => 'Gwall ughkarga',
'uploadlogpage'     => 'Kovnoten ughkarga',
'filename'          => 'Hanow an restren',
'filedesc'          => 'Berrskrif',
'fileuploadsummary' => 'Berrskrif:',
'filesource'        => 'Pennfenten:',
'savefile'          => 'Gwitha restren',
'uploadedimage'     => '"[[$1]]" ughkergys',
'watchthisupload'   => 'Golya an folen-ma',

# Special:ListFiles
'imgfile'               => 'restren',
'listfiles_date'        => 'Dedhyans',
'listfiles_name'        => 'Hanow',
'listfiles_user'        => 'Devnydhyer',
'listfiles_size'        => 'Myns',
'listfiles_description' => 'Deskrifans',
'listfiles_count'       => 'Versyons',

# File description page
'file-anchor-link'          => 'Restren',
'filehist'                  => 'Istori an restren',
'filehist-help'             => 'Klyckyewgh war dhedhyans/eur rag gweles an folen del omdhiskwedhas nena.',
'filehist-deleteall'        => 'dilea oll',
'filehist-deleteone'        => 'dilea',
'filehist-revert'           => 'gorthtreylya',
'filehist-current'          => 'a-lemmyn',
'filehist-datetime'         => 'Dedhyans/Eur',
'filehist-thumb'            => 'Skeusennik',
'filehist-thumbtext'        => 'Skeusennik rag an versyon a-dhia $1',
'filehist-nothumb'          => 'Nyns eus skeusennik',
'filehist-user'             => 'Devnydhyer',
'filehist-dimensions'       => 'Mynsow',
'filehist-filesize'         => 'Mens an restren',
'filehist-comment'          => 'Kampol',
'imagelinks'                => 'Devnydh an restren',
'linkstoimage'              => "Yma an {{PLURAL:$1|folen|$1 folen}} a syw ow kevrenna dhe'n restren-ma:",
'linkstoimage-more'         => "Yma moy es $1 {{PLURAL:$1|folen}} ow kevrenna dhe'n restren-ma.
Ny dhiskwa an rol a syw marnas an {{PLURAL:$1|kynsa kevren folen|kynsa $1 kevren folen}} dhe'n restren-ma.
Yma [[Special:WhatLinksHere/$2|rol leun]] kavadow.",
'nolinkstoimage'            => "Nyns eus folen vyth ow kevrenna dhe'n restren-ma.",
'morelinkstoimage'          => "Gweles [[Special:WhatLinksHere/$1|moy kevrennow]] dhe'n restren-ma.",
'sharedupload'              => 'Yma an folen-ma ow tos dhyworth $1 ha hy a alsa bos yn-dann devnydh gans ragdresow erel.',
'sharedupload-desc-here'    => 'Yma an restren-ma dhe $1 ha ragdresow erel a alsa bos orth hy devnydhya.
Diskwedhys a-woles yw an deskrifans war hy [$2 folen dheskrifans] ena.',
'uploadnewversion-linktext' => "Ughkarga versyon nowyth a'n restren-ma",

# File deletion
'filedelete'        => 'Dilea $1',
'filedelete-legend' => 'Dilea an restren',
'filedelete-submit' => 'Dilea',

# MIME search
'download' => 'iskarga',

# Unwatched pages
'unwatchedpages' => 'Folennow heb aga golya',

# List redirects
'listredirects' => 'Rol an daswedyansow',

# Unused templates
'unusedtemplates'    => 'Skantlyns heb devnydh',
'unusedtemplateswlh' => 'kevrennow erel',

# Random page
'randompage' => 'Folen jonsus',

# Statistics
'statistics'       => 'Statystygyon',
'statistics-pages' => 'Folennow',

'brokenredirects-edit'   => 'chanjya',
'brokenredirects-delete' => 'dilea',

'withoutinterwiki'        => 'Folennow heb kevrennow yeth',
'withoutinterwiki-submit' => 'Diskwedhes',

# Miscellaneous special pages
'nbytes'                  => '$1 {{PLURAL:$1|bayt|bayt}}',
'nmembers'                => '$1 {{PLURAL:$1|esel|esel}}',
'uncategorizedpages'      => 'Folennow heb klass',
'uncategorizedcategories' => 'Klassys heb klass',
'uncategorizedimages'     => 'Restrennow heb klass',
'uncategorizedtemplates'  => 'Skantlyns heb klass',
'unusedcategories'        => 'Klassys heb devnydh',
'unusedimages'            => 'Restrennow heb devnydh',
'prefixindex'             => 'Keniver folen gans an rager',
'shortpages'              => 'Folennow berr',
'longpages'               => 'Folennow hir',
'protectedpages'          => 'Folennow difresys',
'protectedtitles'         => 'Titlys difresys',
'usercreated'             => '{{GENDER:$3|Gwruthys}} an $1 dhe $2',
'newpages'                => 'Folennow nowyth',
'newpages-username'       => 'Hanow-usyer:',
'ancientpages'            => 'An kottha folennow',
'move'                    => 'Gwaya',
'movethispage'            => 'Gwaya an folen-ma',
'pager-newer-n'           => '{{PLURAL:$1|1 nowyttha|$1 nowyttha}}',
'pager-older-n'           => '{{PLURAL:$1|1 kottha|$1 kottha}}',

# Book sources
'booksources'               => 'Pennfentynyow lyver',
'booksources-search-legend' => 'Hwilas pennfentynyow lyver',
'booksources-go'            => 'Mos',

# Special:Log
'specialloguserlabel'  => 'Awtour:',
'speciallogtitlelabel' => 'Kosten (titel po devnydhyer):',
'log'                  => 'Kovnotennow',
'logempty'             => "Nyns eus tra vyth owth omdhesedha y'n govnoten.",

# Special:AllPages
'allpages'       => 'Keniver folen',
'alphaindexline' => '$1 dhe $2',
'prevpage'       => 'Folen gyns ($1)',
'allpagesfrom'   => 'Diskwedhes folennow yn unn dhalleth orth:',
'allpagesto'     => 'Diskwedhes folennow yn unn dhiwedha orth:',
'allarticles'    => 'Keniver folen',
'allpagesprev'   => 'Kyns',
'allpagesnext'   => 'Nessa',
'allpagessubmit' => 'Mos',

# Special:Categories
'categories' => 'Klassys',

# Special:DeletedContributions
'sp-deletedcontributions-contribs' => 'kevrohow',

# Special:LinkSearch
'linksearch'      => 'Hwilas kevrennow a-ves',
'linksearch-ok'   => 'Hwilas',
'linksearch-line' => 'Y kevrennir $1 dhyworth $2',

# Special:ListUsers
'listusersfrom'    => 'Diskwedhes devnydhyoryon yn unn dhalleth orth:',
'listusers-submit' => 'Diskwedhes',

# Special:ActiveUsers
'activeusers'            => 'Rol a dhevnydhyoryon vyw',
'activeusers-intro'      => "Hemm yw rol a dhevnydhyoryon re wrug gwrians war an wiki-ma y'n $1 {{PLURAL:$1|jydh|dydh}} diwettha.",
'activeusers-count'      => "$1 {{PLURAL:$1|wrians|gwrians}} y'n {{PLURAL:$3|jydh|$3 dydh}} diwettha",
'activeusers-hidebots'   => 'Kudha botow',
'activeusers-hidesysops' => 'Kudha menystroryon',

# Special:Log/newusers
'newuserlogpage' => 'Kovnoten gwruthyl akontow devnydhyer',

# Special:ListGroupRights
'listgrouprights-members' => '(rol eseli)',

# Email user
'emailuser'       => 'Ebostya an devnydhyer-ma',
'emailpage'       => 'Ebostya devnydhyer',
'defemailsubject' => 'Ebost danvenys dre {{SITENAME}} gans an devnydhyer "$1"',
'emailfrom'       => 'Dhyworth:',
'emailto'         => 'Dhe:',
'emailmessage'    => 'Messach:',
'emailsend'       => 'Danvon',

# Watchlist
'watchlist'         => 'Rol wolya',
'mywatchlist'       => 'Rol wolya',
'watchlistfor2'     => 'Rag $1 ($2)',
'watch'             => 'Golya',
'watchthispage'     => 'Golya an folen-ma',
'unwatch'           => 'Diswolya',
'watchlist-details' => 'Yma {{PLURAL:$1|$1 folen}} war agas rol wolya, marnas folennow keskows.',
'wlnote'            => "A-woles yma an {{PLURAL:$1|chanj diwettha|'''$1''' chanj diwettha}} y'n {{PLURAL:$2|our|'''$2''' our}} diwettha, a-dhia $3, $4.",
'wlshowlast'        => 'Diskwedhes an $1 our diwettha, an $2 dydh diwettha, po $3',
'watchlist-options' => 'Etholyow an rol wolya',

# Displayed when you click the "watch" button and it is in the process of watching
'watching'   => 'Ow kolya...',
'unwatching' => 'Ow tisgolya...',

'enotif_reset' => 'Merkya pub folen avel vysytyes',

# Delete
'deletepage'            => 'Dilea an folen',
'confirm'               => 'Afydhya',
'excontent'             => 'yth esa ynni: "$1"',
'delete-confirm'        => 'Dilea "$1"',
'delete-legend'         => 'Dilea',
'actioncomplete'        => 'Kowlwrys yw an gwrians',
'actionfailed'          => 'An gwrians a fyllis',
'deletedtext'           => '"$1" re beu diles.
Gwelewgh $2 rag kovadh a dhileansow a-dhiwedhes.',
'dellogpage'            => 'Kovnoten dhilea',
'deletionlog'           => 'kovnoten dhilea',
'deletecomment'         => 'Acheson:',
'deleteotherreason'     => 'Acheson aral/keworansel:',
'deletereasonotherlist' => 'Acheson aral',

# Rollback
'rollbacklink' => 'revya war-dhelergh',

# Protect
'protectlogpage'          => 'Kovnoten dhifres',
'protectedarticle'        => '"[[$1]]" difresys',
'prot_1movedto2'          => '[[$1]] gwayys dhe [[$2]]',
'protectcomment'          => 'Acheson:',
'protectexpiry'           => 'Ow tiwedha:',
'protect_expiry_invalid'  => 'Drog yw an termyn diwedha.',
'protect_expiry_old'      => "Yma an termyn diwedha y'n termyn eus passyes.",
'protect-level-sysop'     => 'Alowa menystroryon hepken',
'protect-summary-cascade' => 'ow froslamma',
'protect-expiring'        => 'diwedhans $1 (UTC)',
'restriction-type'        => 'Kummyas:',
'pagesize'                => '(bayt)',

# Restrictions (nouns)
'restriction-edit'   => 'Chanjya',
'restriction-move'   => 'Gwaya',
'restriction-create' => 'Gwruthyl',
'restriction-upload' => 'Ughkarga',

# Undelete
'undeletelink'              => 'gweles/gorthtreylya',
'undeleteviewlink'          => 'gweles',
'undelete-search-submit'    => 'Hwilas',
'undelete-show-file-submit' => 'Ya',

# Namespace form on various pages
'namespace'             => 'Spas hanow:',
'invert'                => 'Trebuchya an dewisyans',
'namespace_association' => 'Spas hanow kelmys',
'blanknamespace'        => '(Penn)',

# Contributions
'contributions'       => 'Kevrohow an devnydhyer',
'contributions-title' => 'Kevrohow $1',
'mycontris'           => 'Kevrohow',
'contribsub2'         => 'Rag $1 ($2)',
'uctop'               => '(gwartha)',
'month'               => 'Dhyworth an mis (ha moy a-varr):',
'year'                => 'Dhyworth an vledhen (ha moy a-varr):',

'sp-contributions-newbies'  => 'Diskwedhes yn unnik kevrohow akontow nowyth',
'sp-contributions-blocklog' => 'kovnoten lettya',
'sp-contributions-uploads'  => 'ughkargansow',
'sp-contributions-logs'     => 'kovnotennow',
'sp-contributions-talk'     => 'keskows',
'sp-contributions-search'   => 'Hwilas kevrohow',
'sp-contributions-username' => 'Trigva IP po hanow devnydhyer:',
'sp-contributions-toponly'  => 'Diskwedhes yn unnik chanjyow yw amendyansow diwettha',
'sp-contributions-submit'   => 'Hwilas',

# What links here
'whatlinkshere'            => 'Pyth a gevren dhe omma',
'whatlinkshere-title'      => 'Folennow ow kevrenna dhe "$1"',
'whatlinkshere-page'       => 'Folen:',
'linkshere'                => "Yma an folennow a syw ow kevrenna dhe '''[[:$1]]''':",
'nolinkshere'              => "Nyns eus folen vyth ow kevrenna dhe '''[[:$1]]'''.",
'isredirect'               => 'folen daskedyans',
'istemplate'               => 'treuskludyans',
'isimage'                  => 'kevren an restren',
'whatlinkshere-prev'       => '{{PLURAL:$1|kyns|$1 kyns}}',
'whatlinkshere-next'       => '{{PLURAL:$1|nessa|nessa $1}}',
'whatlinkshere-links'      => '??? kevrennow',
'whatlinkshere-hideredirs' => '$1 daskedyansow',
'whatlinkshere-hidetrans'  => '$1 treuskludyans',
'whatlinkshere-hidelinks'  => '$1 kevrennow',
'whatlinkshere-hideimages' => '$1 kevrennow restren',
'whatlinkshere-filters'    => 'Sidhlow',

# Block/unblock
'blockip'                    => 'Lettya devnydhyer',
'ipadressorusername'         => 'Trigva IP po hanow-usyer:',
'ipbreason'                  => 'Acheson:',
'ipbreasonotherlist'         => 'Acheson aral',
'ipboptions'                 => '2 our:2 hours,1 jydh:1 day,3 dydh:3 days,1 seythen:1 week,2 seythen:2 weeks,1 vis:1 month,3 mis:3 months,6 mis:6 months,1 vledhen:1 year,heb diwedh:infinite',
'ipb-blocklist-contribs'     => 'Kevrohow rag $1',
'ipblocklist'                => 'Devnydhyoryon lettyes',
'ipblocklist-submit'         => 'Hwilas',
'blocklink'                  => 'lettya',
'unblocklink'                => 'dislettya',
'change-blocklink'           => 'chanjya an lettyans',
'contribslink'               => 'kevrohow',
'blocklogpage'               => 'Kovnoten lettya',
'blocklogentry'              => '[[$1]] lettyes, bys dhe $2 $3',
'unblocklogentry'            => '$1 dislettyes',
'block-log-flags-anononly'   => 'devnydhyoryon dhihanow hepken',
'block-log-flags-nocreate'   => 'dialosegys yw gwruthyl akontow',
'block-log-flags-hiddenname' => 'hanow devnydhyer kudhys',

# Move page
'move-page'            => 'Gwaya $1',
'move-page-legend'     => 'Gwaya folen',
'movepagetext'         => "Devnydhya an furvlen a-woles a dhashenow folen, yn unn waya oll y istori dhe'n hanow nowyth.
An titel koth a vydh folen dhaskedyans dhe'n titel nowyth.
Hwi a yll nowedhi daskedyansow a boynt dhe'n titel derowel yn awtomatek.
Mar ny wrewgh, surhewgh hwi dhe jeckya rag [[Special:DoubleRedirects|daskedyansow dobyl]] po [[Special:BrokenRedirects|terrys]].
Omgemeryansek owgh rag surhe y pes kevrennow poyntya dhe'n tyller ewn.

Notyewgh '''na wayir''' an folen mars eus folen orth an titel nowyth seulabrys, marnas bos an pyth kampollys diwettha daskedyans ha ny'n jeves istori chanjya kyns vyth.
Hemm a styr y hyllowgh diswul dashenwel folen mar kwrewgh kammwrians, ha ny yllowgh gorskrifa folen eus ena seulabrys.

'''Gwarnyans!'''
Hemm a yll bos chanj tromm ha bras dres ehen rag folen gerys-da;
Surhewgh mar pleg hwi dhe gonvedhes sewyansow an gwrians-ma kyns mos yn-rag.",
'movearticle'          => 'Gwaya an folen:',
'moveuserpage-warning' => "'''Gwarnyans''': Yth esowgh ow mos dhe waya folen dhevnydhyer. Notyewgh mar pleg ny vydh marnas an folen gwayys ha ''ny vydh'' an devnydhyer dashenwys.",
'newtitle'             => 'Dhe ditel nowyth:',
'move-watch'           => 'Golya an folen-ma',
'movepagebtn'          => 'Gwaya an folen',
'pagemovedsub'         => 'Gwaya a sewenis',
'movepage-moved'       => '\'\'\'Gwayys re beu "$1" dhe "$2"\'\'\'',
'movedto'              => 'gwayys dhe',
'movelogpage'          => 'Kovnoten waya',
'movenosubpage'        => "Ny's teves an folen-ma isfolen vyth.",
'movereason'           => 'Acheson:',
'revertmove'           => 'gorthtreylya',

# Export
'export'        => 'Esperthi folennow',
'export-addcat' => 'Keworra',
'export-addns'  => 'Keworra',

# Namespace 8 related
'allmessagesname'    => 'Hanow',
'allmessagesdefault' => 'Tekst messach defowt',

# Thumbnails
'thumbnail-more'  => 'Brashe',
'thumbnail_error' => 'Gwall ow kwruthyl skeusennik: $1',

# Special:Import
'import'                  => 'Ymperthi folennow',
'import-interwiki-submit' => 'Ymperthi',
'import-upload-filename'  => 'Hanow an restren:',
'importstart'             => 'Owth ymperthi folennow...',
'import-noarticle'        => 'Nyns eus folen vyth dhe ymperthi!',

# Tooltip help for the actions
'tooltip-pt-userpage'             => 'Agas folen dhevnydhyer',
'tooltip-pt-mytalk'               => 'Agas folen gows',
'tooltip-pt-preferences'          => 'Agas dewisyansow',
'tooltip-pt-watchlist'            => 'Rol a folennow esowgh ow kolya rag chanjyow',
'tooltip-pt-mycontris'            => "Rol a'gas kevrohow",
'tooltip-pt-login'                => 'Ni a gomend mayth omgelmowgh, mes nyns yw besi',
'tooltip-pt-logout'               => 'Digelmi',
'tooltip-ca-talk'                 => "Dadhlow a-dro dhe'n folen",
'tooltip-ca-edit'                 => "Hwi a yll chanjya an folen-ma. Devnydhyewgh an boton 'ragweles' kyns gwitha mar pleg.",
'tooltip-ca-addsection'           => 'Dalleth tregh nowyth',
'tooltip-ca-viewsource'           => 'Difresys yw an folen-ma.
Hwi a yll gweles hy fennfenten.',
'tooltip-ca-history'              => "Amendyansow koth a'n folen-ma",
'tooltip-ca-protect'              => 'Difres an folen-ma',
'tooltip-ca-delete'               => 'Dilea an folen-ma',
'tooltip-ca-move'                 => 'Gwaya an folen-ma',
'tooltip-ca-watch'                => "Keworra an folen-ma dhe'gas rol wolya",
'tooltip-ca-unwatch'              => 'Dilea an folen-ma dhyworth agas rol wolya',
'tooltip-search'                  => 'Hwilas yn {{SITENAME}}',
'tooltip-search-go'               => 'Mos dhe folen gans an keth hanow-ma, mars eus',
'tooltip-search-fulltext'         => "Hwilas an tekst-ma y'n folennow",
'tooltip-p-logo'                  => "Mos dhe'n folen dynnargh",
'tooltip-n-mainpage'              => "Mos dhe'n folen dynnargh",
'tooltip-n-mainpage-description'  => "Mos dhe'n folen dynnargh",
'tooltip-n-portal'                => "A-dro dhe'n ragdres, an pyth a yllowgh gul, ple hyllir kavos taklow",
'tooltip-n-currentevents'         => 'Kavos kedhlow a-dro dhe hwarvosow a-lemmyn',
'tooltip-n-recentchanges'         => "Rol a janjyow a-dhiwedhes y'n wiki",
'tooltip-n-randompage'            => 'Karga folen jonsus',
'tooltip-n-help'                  => 'Gweres',
'tooltip-t-whatlinkshere'         => 'Rol a bub folen wiki a gevren dhe omma',
'tooltip-t-recentchangeslinked'   => 'Chanjyow a-dhiwedhes yn folennow a gevrennir dhyworth an folen-ma',
'tooltip-feed-rss'                => 'Feed RSS rag an folen-ma',
'tooltip-feed-atom'               => 'Feed Atom rag an folen-ma',
'tooltip-t-contributions'         => 'Gweles rol a gevrohow an devnydhyer-ma',
'tooltip-t-emailuser'             => "Danvon ebost dhe'n devnydhyer-ma",
'tooltip-t-upload'                => 'Ughkarga restrennow',
'tooltip-t-specialpages'          => 'Rol a geniver folen arbennek',
'tooltip-t-print'                 => "Versyon pryntyadow a'n folen-ma",
'tooltip-t-permalink'             => "Kevren fast dhe'n amendyans-ma a'n folen",
'tooltip-ca-nstab-main'           => 'Gweles an folen',
'tooltip-ca-nstab-user'           => 'Gweles an folen dhevnydhyer',
'tooltip-ca-nstab-special'        => 'Folen arbennek yw homma; ny yllowgh chanjya an folen hy honen.',
'tooltip-ca-nstab-project'        => 'Gweles folen an wiki',
'tooltip-ca-nstab-image'          => 'Gweles folen an restren',
'tooltip-ca-nstab-template'       => 'Gweles an skantlyn',
'tooltip-ca-nstab-category'       => 'Gweles folen an klass',
'tooltip-minoredit'               => 'Merkya hemma avel chanj byhan',
'tooltip-save'                    => 'Gwitha agas chanjyow',
'tooltip-preview'                 => 'Ragweles agas chanjyow; devnydhyewgh hemma kyns gwitha mar pleg!',
'tooltip-diff'                    => "Diskwedhes an chanjyow a wrussowgh dhe'n tekst",
'tooltip-compareselectedversions' => 'Gweles an dyffransow ynter dew amendyansow dewisyes an folen-ma',
'tooltip-watch'                   => "Keworra an folen-ma dhe'gas rol wolya",
'tooltip-rollback'                => '"Revya war-dhelergh" a worthtreyl chanjyow an diwettha devnydhyer yn unn glyck',
'tooltip-undo'                    => '"Diswul" a worthtreyl an chanj-ma hag ygeri an furvlen janjya y\'n modh ragweles. Y hyllir keworra acheson y\'n berrskrif.',
'tooltip-summary'                 => 'Entrewgh berrskrif',

# Attribution
'siteuser'         => 'devnydhyer {{SITENAME}} $1',
'lastmodifiedatby' => 'Chanj diwettha an folen-ma o dhe $2, $1 gans $3.',
'siteusers'        => '{{PLURAL:$2|devnydhyer|devnydhyoryon}} {{SITENAME}} $1',

# Browsing diffs
'previousdiff' => '??? Chanj kottha',
'nextdiff'     => 'Chanj nowyttha ???',

# Media information
'file-info-size' => '$1 ?? $2 piksel, myns an restren: $3, ehen MIME: $4',
'file-nohires'   => 'Nyns eus klerder uhella kavadow.',
'svg-long-desc'  => 'Restren SVG, $1 ?? $2 piksel yn hanow, myns an restren: $3',
'show-big-image' => 'Klerder leun',

# Special:NewFiles
'ilsubmit' => 'Hwilas',

# Metadata
'metadata'          => 'Metadata',
'metadata-help'     => "An restren-ma a's teves kedhlow keworansel, dres lycklod keworrys dhyworth an kamera bysyel po an skanyer devnydhys rag hy gwruthyl po hy bysya. Mars yw chanjys an restren dhyworth hy studh gwredhek, possybyl yw na veu nebes manylyon nowedhys.",
'metadata-expand'   => 'Diskwedhes manylyon ystynnys',
'metadata-collapse' => 'Kudha manylyon ystynnys',

# EXIF tags
'exif-imagewidth'  => 'Les',
'exif-imagelength' => 'Uhelder',
'exif-artist'      => 'Awtour',

'exif-meteringmode-255' => 'Aral',

'exif-contrast-0' => 'Usadow',
'exif-contrast-1' => 'Medhel',
'exif-contrast-2' => 'Kales',

'exif-saturation-0' => 'Usadow',

'exif-sharpness-0' => 'Usadow',
'exif-sharpness-1' => 'Medhes',
'exif-sharpness-2' => 'Kales',

'exif-subjectdistancerange-0' => 'Ankoth',

# External editor support
'edit-externally' => 'Chanjya an restren-ma dre dowlen a-ves',

# 'all' in various places, this might be different for inflected languages
'watchlistall2' => 'puptra',
'namespacesall' => 'oll',
'monthsall'     => 'oll',
'limitall'      => 'oll',

# Email address confirmation
'confirmemail'         => 'Afydhya an drigva ebost',
'confirmemail_noemail' => "Nyns eus trigva ebost da settyes y'gas [[Special:Preferences|dewisyansow devnydhyer]].",

# Multipage image navigation
'imgmultipageprev' => '??? folen gyns',
'imgmultipagenext' => 'folen nessa ???',
'imgmultigo'       => 'Mos',

# Table pager
'table_pager_limit_submit' => 'Mos',

# Auto-summaries
'autosumm-blank'   => 'Gwakhes veu an folen',
'autoredircomment' => 'Folen daskedyes war-tu ha [[$1]]',
'autosumm-new'     => "Folen gwruthys gans: '$1'",

# Live preview
'livepreview-loading' => 'Ow karga...',
'livepreview-ready'   => 'Ow karga... Parys!',

# Watchlist editor
'watchlistedit-noitems'        => "Nyns eus folen vyth y'gas rol wolya.",
'watchlistedit-normal-title'   => 'Chanjya an rol wolya',
'watchlistedit-normal-legend'  => 'Dilea folennow dhyworth agas rol wolya',
'watchlistedit-normal-explain' => 'Yma diskwedhys a-woles folennow war agas rol wolya.
Rag dilea folen, checkyewgh an gisten rybdhi, ha klyckyewgh "{{int:Watchlistedit-normal-submit}}".
Hwi a yll [[Special:EditWatchlist/raw|chanjya restren an rol wolya]] ynwedh.',
'watchlistedit-normal-submit'  => 'Dilea titlys',
'watchlistedit-normal-done'    => 'Diles veu {{PLURAL:$1|$1 titel}} dhyworth agas rol golyas',
'watchlistedit-raw-title'      => 'Chanjya restren an rol wolya',
'watchlistedit-raw-legend'     => 'Chanjya restren an rol wolya',
'watchlistedit-raw-explain'    => 'Yma diskwedhys a-woles folennow war agas rol wolya, may hyllir hy chanjya dre geworra dhedhi ha dilea dhyworti;
unn ditel war unn linen.
Pan vowgh gorfennys, klyckyewgh "{{int:Watchlistedit-raw-submit}}".
Hwi a yll [[Special:EditWatchlist|devnydhya an janjyel usadow]] ynwedh.',
'watchlistedit-raw-titles'     => 'Titlys:',
'watchlistedit-raw-submit'     => 'Nowedhi an rol wolya',
'watchlistedit-raw-done'       => 'Nowedhys re beu agas rol wolya.',
'watchlistedit-raw-added'      => 'Keworrys veu {{PLURAL:$1|$1 titel}}:',
'watchlistedit-raw-removed'    => 'Diles veu {{PLURAL:$1|$1 titel}}:',

# Watchlist editing tools
'watchlisttools-view' => 'Gweles chanjyow longus',
'watchlisttools-edit' => 'Gweles ha chanjya an rol wolya',
'watchlisttools-raw'  => 'Chanjya restren an rol wolya',

# Signatures
'signature' => '[[{{ns:user}}:$1|$2]] ([[{{ns:user_talk}}:$1|keskows]])',

# Special:Version
'version'         => 'Versyon',
'version-other'   => 'Aral',
'version-version' => '(Versyon $1)',

# Special:FilePath
'filepath-page' => 'Restren:',

# Special:FileDuplicateSearch
'fileduplicatesearch-filename' => 'Hanow an restren:',
'fileduplicatesearch-submit'   => 'Hwilas',

# Special:SpecialPages
'specialpages'             => 'Folennow arbennek',
'specialpages-group-login' => 'Omgelmi / gwruthyl akont',

# Special:BlankPage
'blankpage' => 'Folen wag',

# Special:Tags
'tag-filter' => 'Sidhel [[Special:Tags|tagyow]]:',
'tags-edit'  => 'chanjya',

# Database error messages
'dberr-header'    => "An wiki-ma a'n jeves kudyn",
'dberr-problems'  => "Drog yw genen! An wiasva-ma a's teves kaletter teknogel.",
'dberr-again'     => 'Assayewgh gortos pols ha daskarga.',
'dberr-info'      => '(Ny yllir kestava orth servyer an database: $1)',
'dberr-usegoogle' => 'Hwi a yll assaya hwilas dre Google.',

# New logging system
'logentry-delete-delete' => '$1 a dhileas an folen $3',

);
