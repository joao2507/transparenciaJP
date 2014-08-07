<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="pt-br"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="pt-br"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="pt-br"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="pt-br"> <!--<![endif]-->
    <head>

        <meta charset="utf-8">
        <title>TransparênciaJP - Aplicativo Mobile</title>
        <meta name="description" content="Aplicativo mobile que acompanha os gastos público da Prefeitura Municipal de João Pessoa, desenvolvido pela Secretaria de Transparência Pública">
        <meta name="author" content="DGPI/SETRANSP">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <link rel="stylesheet" href="stylesheets/base.css">
        <link rel="stylesheet" href="stylesheets/skeleton.css">
        <link rel="stylesheet" href="stylesheets/layout.css">

        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="images/16.png">

        <meta property="og:image" content="http://www.fomsege.com.br/app/images/150.png" />
        <meta property="og:url" content="http://www.fomsege.com.br/app/" />
        <meta property="og:title" content="TransparênciaJP" />
        <meta property="og:description" content="Dados público municipais na palma da sua mão" />

    </head>
    <body>
        <div class="container">
            <h1 class="no-indent"><a href="/app">TransparênciaJP - Aplicativo Mobile</a></h1>
            <ul>
                <li><a  href="https://play.google.com/store/apps/details?id=br.com.bossacriativa.transparenciajp"><img src="images/icon-android.png" alt="icone android"></a></li>
                <li><a href="https://itunes.apple.com/us/app/transparenciajp/id744644905?l=pt&ls=1&mt=8"><img src="images/icon-ios.png" alt="icone ios"></a></li>
                <li style="margin-right: 0;padding-top: 10px;padding-left: 5px;"><a href="apk/transparenciajp.apk"><img src="images/icon-apk.png" alt="icone apk"></a></li>
            </ul>
            <div class="clear"></div>
            <div align="center"><a href="http://www.joaopessoa.pb.gov.br"><img src="images/logo-pmjp.png" /></a></div>
        </div><!-- container -->
    </body>
    <script type="text/javascript">
        var isiDevice = /ipad|iphone|ipod/i.test(navigator.userAgent.toLowerCase());
        var isAndroid = /android/i.test(navigator.userAgent.toLowerCase());

        if (isiDevice){
            window.location = 'https://itunes.apple.com/us/app/transparenciajp/id744644905?l=pt&ls=1&mt=8';
        } else if (isAndroid) {
            window.location = 'https://play.google.com/store/apps/details?id=br.com.bossacriativa.transparenciajp';
        }
        
    </script>
</html>