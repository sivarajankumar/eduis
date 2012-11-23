<link rel="stylesheet"
	href="<?php
echo 'http://' . CDN_SERVER . '/css/admission.css';
?>">
<div id="main">
<div id="sidebar" style="float: left">
<ul class="menu">
	<li class="item2"><a href="#">Personal Information</a>
	<ul>
		<li class="subitem1"><a href="/member/viewpersonalinfo"
			target="content_frame">View</a></li>
		<!-- Student can only update his personal information -->
		<li class="subitem1"><a href="/student/editpersonalinfo"
			target="content_frame">Update</a></li>
	</ul>
	</li>

	<li class="item1"><a href="#">Class Information</a>
	<ul>
		<li class="subitem1"><a href="/student/viewclassinfo"
			target="content_frame">View</a></li>
		<li class="subitem1"><a href="/student/addclassinfo"
			target="content_frame">Add</a></li>
	</ul>
	</li>

</ul>
</div>
</div>
<script type="text/javascript">
	$(function() {

		$('#topnav').hide();
		$('#core_link').css('background-color','#b3cdd6');
		$('#core_link').css('border','1px solid black');
		$('#core_link').css('padding','5px 6px');
		
        var menu_ul = $('.menu > li > ul'),
		menu_a  = $('.menu > li > a');

        menu_ul.hide();
    
        menu_a.click(function(e) {
			e.preventDefault();
            if(!$(this).hasClass('active')) {
                menu_a.removeClass('active');
                menu_ul.filter(':visible').slideUp('normal');
                $(this).addClass('active').next().stop(true,true).slideDown('normal');
            } else {
                $(this).removeClass('active');
                $(this).next().stop(true,true).slideUp('normal');
            }
        });

        $('.menu > li > a:first').click();
        var path = $('.subitem1 > a').attr('href');
        $('#content_frame').attr('src',path);

        var urlfetchimagelocation = 'http://core.aceambala.com/student/getimagename';
        $.ajax({
			url : urlfetchimagelocation,
			data : {format : 'jsonp'},
			dataType : 'jsonp',
			success : function(jStatus){
				if((jStatus == null) || (jStatus == false)|| (jStatus == undefined))
					$('#student_img').attr('src','http://site.cdn.aceambala.com/images/memberimages/dummy.jpg');
				else
					$('#student_img').attr('src','http://site.cdn.aceambala.com/images/memberimages/'+jStatus);
			},
			error : function(response){

			}
        });
    });

	function hide_top()
	{
		$('iframe#content_frame').contents().find('div#topContent').hide();		
	}

</script>

<style type="text/css">
#page_content {
	float: left;
	width: 65%;
}

div#main {
	margin-top: 10px;
}

div#student_navigation {
	background-color: #d6ebf2;
	border: 0.1em solid #97afb7;
	border-radius: 2px;
	margin: 10px 0;
	padding: 11px;
}

ul#list {
	padding: 5px 5px 5px 5px;
	list-style: none outside none;
	margin: 0;
}

ul#list>li {
	display: inline;
	padding: 5px 6px 5px 6px;
}

ul#list>li:hover {
	display: inline;
	padding: 5px 5px 5px 5px;
	background-color: #b3cdd6;
	border: 1px solid black;
}

ul#list>li>a {
	text-decoration: none;
	color: black;
}

#student_img {
	float: left;
	border: 1px solid grey;
	border-radius: 2px;
	margin: -5px 10px 0 -3px;
}
</style>