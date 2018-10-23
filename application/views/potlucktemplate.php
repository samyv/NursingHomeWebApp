<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
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
        <h1>PotLuck</h1>
        <h2>UXWD's demo site</h2>
    </div>
    <nav>
       <!--{menu_items}
        <a href="{link}" title="{title}" class="{className}"    >{name}</a>
        {/menu_items}
-->

                <a href="home">Home</a>
                <a href="#">Tips</a>
                <a href="create.php">Create</a>
                <a href="about">About</a>
                <a href="events">Events</a>

            </nav>
        </header>
        <main>
            <section>
                <h2>{content_title_1}</h2>
                <h3>{content_title_2}</h3>
                {content}
            </section>
            <aside>
                <article>
                    <h3>Latest PotLuck...</h3>
                    <ul>
                        <li><a href="#">Happy Hour @ Koen</a></li>
                        <li><a href="#">Vero goes Culinar</a></li>
                        <li><a href="#">Jeroen's (Pot)Lucky-evening</a></li>
                    </ul>
                </article>
                <article>
                    <h3>Feedback</h3>
                    <p>This concept is awesome! Also the site looks nice and stylish <em>(Jeroen)</em></p>
                    <p>Is there also a mobile app for this site? <em>(Patrick)</em></p>
                    <p>Student cooking with <a href="https://dagelijksekost.een.be/gerechten/noedelwok-met-varkensreepjes-chinese-kool-en-een-spiegelei" target="_blank">Dagelijkse Kost</a>
                </article>
            </aside>
        </main>
        <footer>
            <p>Copyright © 2018 UXWD. Groep T All Rights Reserved.
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
            </p>
        </footer>
        </body>
        </html>