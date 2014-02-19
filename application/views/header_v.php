<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="" width="device-width,initial-scale=1, user-scalable=no" />
    <title>CodeIgniter</title>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link type="text/css" rel='stylesheet' href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"/>
    <script>
        $(document).ready(function(){
           $("#search_btn").click(function(){
               if($("#q").val() == ''){
                   alert('검색어를 입력하세요');
                   return false;
               }else{
                   var act = '/bbs/board/lists/ci_board/q/'+$("#q").val()+'/page/1';
                   $("#bd_search").attr('action', act).submit();
               }
           });
        });

        function board_search_enter(form){
            var keycode = window.event.keyCode;
            if(keycode == 13) $("#search_btn").click();
        }
    </script>
</head>
<body>
<div id="main">
    <header id="header" data-role="header" data-position="fixed"><!-- Header Start -->
        <blockquote>
            <p>만들면서 배우는 CodeIgniter</p>
            <small>실행 예제</small>
        </blockquote>
    </header><!-- Header End -->

    <nav id="gnb"><!-- gnb Start -->
        <ul>
            <li><a rel="external" href="/bbs/<?php echo $this->uri->segment(1);?>/lists/<?php echo $this->uri->segment(3);?>">게시판 프로젝트</a></li>
        </ul>
    </nav><!-- gnb End -->