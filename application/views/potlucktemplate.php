<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>

    <link href="<?= base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url()?>assets/css/main.css" rel="stylesheet" type="text/css"/>
    <meta charset="UTF-8" />
    <meta name="keywords" content="UXWD's course demo" />
    <meta name="description"
          content="This a demonstration site for the UXWD's course. But still... the question is... who will cook tonight?" />
    <link href="https:/>/fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">
    <!--  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js">
      </script> -->
</head>

<body>
<header>
    <div id="logo">
        <h1>GraceAge</h1>
        <h2>Providing better care</h2>
    </div>
    <nav>
       {menu_items}
        <a href="{link}" title="{title}" class="{className}">{name}</a>
        {/menu_items}
    </nav>
        </header>
        <main>
            <section>
                {content}
            </section>

        </main>
        <footer>
            <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved. <img src="<?=base_url()?>assets/images/KULEUVEN_CMYK_LOGO.png" id="KULEUVENLOGO">
            </p>
        </footer>
        </body>
        </html>