<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to your first page!</title>
        <link rel="stylesheet" href="{{asset('assets/block_page_asset/style.css')}}">
    </head>
    <body>
        <div id="wrapper">
            <div id="moving-background">
                <div id="parallax" class="clear">
                    <div id="last-layer" class="parallax-layer">
                        <img src="{{asset('assets/block_page_asset/final-background.png')}}" alt="final background" />
                    </div>
                    <div id="bottom-layer" class="parallax-layer">
                        <img src="{{asset('assets/block_page_asset/middle-layer.png')}}" />
                    </div>
                    <div id="top-layer" class="parallax-layer">
                        <img src="{{asset('assets/block_page_asset/top-layer.png')}}" />
                    </div>
                </div>
            </div>
            <div id="circles">
                <ul class="container">
                    <li>
                        <div class="inner-circles">
                            <p>1</p>
                        </div>
                        <h3>
                            Go to your <strong>Control Panel</strong>
                        </h3>
                    </li>
                    <li>
                        <div class="inner-circles">
                            <p>2</p>
                        </div>
                        <h3>
                            <strong>Upload</strong> your website or use our <strong>Zacky Website Builder & Installer</strong>
                        </h3>
                    </li>
                    <li>
                        <div class="inner-circles">
                            <p>3</p>
                        </div>
                        <h3>
                            <strong>Enjoy</strong> your website
                        </h3>
                    </li>
                </ul>
            </div>
        </div>
        <script src="{{asset('assets/block_page_asset/jquery.min.js')}}"></script>
        <script src="{{asset('assets/block_page_asset/jquery.event.frame.js')}}"></script>
        <script src="{{asset('assets/block_page_asset/jquery.parallax.js')}}"></script>
        <script src="{{asset('assets/block_page_asset/main.js')}}"></script>
    </body>
</html>
