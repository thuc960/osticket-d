<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?907ec36" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?907ec36"
         media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?907ec36"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?907ec36" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?907ec36"/>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js?907ec36"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?907ec36"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js?907ec36"></script>
   <!------------------------------------    ----------> 
<link rel="stylesheet" type="text/css" href="css/themes/bootstrap/easyui.css">
	<link rel="stylesheet" type="text/css" href="css/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="css/demo/demo.css">


<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery.easyui.min.js"></script>
    
     <script>//得到当前日期

	formatterDate = function(date)
	{
		var day = date.getDate() > 9 ? date.getDate() : "0" + date.getDate();
		var month = (date.getMonth() + 0) > 9 ? (date.getMonth() + 0) : "0"
		+ (date.getMonth() + 0);
		return date.getFullYear() + '-' + month + '-' + day;
	};
	
	formatterDate2 = function(date)
	{
		var day = date.getDate() > 9 ? date.getDate() : "0" + date.getDate();
		var month = (date.getMonth() + 1) > 9 ? (date.getMonth() + 1) : "0"
		+ (date.getMonth() + 1);
		return date.getFullYear() + '-' + month + '-' + day;
	};
	
	window.onload = function ()
	{
		$('#date_submitted').datebox('setValue', formatterDate(new Date()));
		$('#enddate_submitted').datebox('setValue', formatterDate2(new Date()));
	}
 </script>
    
	<script type="text/javascript">
		function doSearch(){
			
			$('#tt').datagrid('load',{
				needs:$('#suser').val(),
				startdate: $('#date_submitted').datebox("getValue"),
				enddate: $('#enddate_submitted').datebox("getValue"),
				cate: $('#cid').combobox('getValue'),
				status: $('#stu').combobox('getValue'),
				summary: $('#getsummary').val()
			});
		}
	</script>
    
    <script type="text/javascript">
		function getSelected(){
			var row = $('#tt').datagrid('getSelected');
			if (row){
				//alert('Item ID:'+row.bug_id+"\nPrice:"+row.value);
				//document.location.href="http://dsweb.dintsun.com.tw/mantis/view.php?id="+row.BUG_ID;
				if(row.SEND_STATUS == "Y")
				{
					alert('已做過滿意度調查');
				}else if(row.FDATE == "")
				{
					alert('無結案日期，請先至Mantis結案');
				}else{
						document.location.href="http://dsweb.dintsun.com.tw/mantis/easyui/mailservice/sendmail.php?id="+row.BUG_ID+"&summary="+row.summary+"&sendate="+row.SEND_DATE+"&"+row.EMAIL;
					}
					
				
			}
		}
		
		
		function getSelectBugid(){
			var low = $('#tt').datagrid('getSelected');
			if (low){
				//alert('Item ID:'+row.bug_id+"\nPrice:"+row.value);
				document.location.href="http://dsweb.dintsun.com.tw/mantis/view.php?id="+low.BUG_ID;
			}
		}
		
		
	</script>
    
    <script type="text/javascript">
	
    $(document).ready(function(){
      $("#date_submitted").datebox({
        formatter:function(date){
          var y=date.getFullYear();
          var m=date.getMonth()+1;
          var d=date.getDate();
          return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);        
          },
        parser:function(s){
          var t=Date.parse(s);
          if (!isNaN(t)) {return new Date(t);}
          else {return new Date();}
          }      
        });
      });
	  
	  $(document).ready(function(){
      $("#enddate_submitted").datebox({
        formatter:function(date){
          var y=date.getFullYear();
          var m=date.getMonth()+1;
          var d=date.getDate();
          return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);        
          },
        parser:function(s){
          var t=Date.parse(s);
          if (!isNaN(t)) {return new Date(t);}
          else {return new Date();}
          }      
        });
      });
	  
  	</script>
    <!-- -----------------------------------------------------    -->
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
<?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
            hreflang="x-default" />
<?php
    }
    ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <div class="pull-right flush-right">
            <p>
             <?php
                if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                    && !$thisclient->isGuest()) {
                 echo Format::htmlchars($thisclient->getName()).'&nbsp;|';
                 ?>
                <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> |
                <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a> -
                <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
            <?php
            } elseif($nav) {
                if ($cfg->getClientRegistrationMode() == 'public') { ?>
                    <?php echo __('Guest User'); ?> | <?php
                }
                if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                    <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a><?php
                }
                elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                    <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
<?php
                }
            } ?>
            </p>
            <p>
<?php
if (($all_langs = Internationalization::getConfiguredSystemLanguages())
    && (count($all_langs) > 1)
) {
    $qs = array();
    parse_str($_SERVER['QUERY_STRING'], $qs);
    foreach ($all_langs as $code=>$info) {
        list($lang, $locale) = explode('_', $code);
        $qs['lang'] = $code;
?>
        <a class="flag flag-<?php echo strtolower($locale ?: $info['flag'] ?: $lang); ?>"
            href="?<?php echo http_build_query($qs);
            ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>">&nbsp;</a>
<?php }
} ?>
            </p>
            </div>
            <a class="pull-left" id="logo" href="<?php echo ROOT_PATH; ?>index.php"
            title="<?php echo __('Support Center'); ?>">
                <span class="valign-helper"></span>
                <img src="<?php echo ROOT_PATH; ?>logo.php" border=0 alt="<?php
                echo $ost->getConfig()->getTitle(); ?>"
 	 style="height: 10.8em">
        </a>
        </div>
        <div class="clear"></div>
        <?php
        if($nav){ ?>
        <ul id="nav" class="flush-left">
            <?php
            if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                foreach($navs as $name =>$nav) {
                    echo sprintf('<li><a class="%s %s" href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                }
            } ?>
        </ul>
        <?php
        }else{ ?>
         <hr>
        <?php
        } ?>
        <div id="content">

         <?php if($errors['err']) { ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
         <?php } ?>
