<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="icon" href="/icons/favicon.ico"/>
        <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png"/>
        <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-touch-icon-57x57.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-touch-icon-72x72.png"/>
        <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-touch-icon-76x76.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-touch-icon-114x114.png"/>
        <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-touch-icon-120x120.png"/>
        <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-touch-icon-144x144.png"/>
        <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-touch-icon-152x152.png"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon-180x180.png"/>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <meta name="description" content="Dashboard - self-hosted startpage for your server"/>
        <link rel="stylesheet" href="/css/main.css"/>
        <title>Dashboard</title>
    </head>
    <body>
        <div id="root">
          <div class="Layout_Container__2Hv3J">
            <header class="Header_Header__2oavH">
              <p><?php echo date("l, j F Y");?></p>
              <a class="Header_SettingsLink__3ublJ" href="/settings">Go to Settings</a>
              <span class="Header_HeaderMain__ZUhf5">
                <h1>Good evening!</h1>
                <div class="WeatherWidget_WeatherWidget__1Wn8c">
                  <div>
                    <canvas id="weather-icon" width="50" height="50"></canvas>
                  </div>
                  <div class="WeatherWidget_WeatherDetails__2JUm1">
                    <span>3.4°C</span>
                    <span>69%</span>
                  </div>
                </div>
              </span>
            </header>
            <a href="/applications">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_">Applications</h2>
            </a>
            <div class="AppGrid_AppGrid__33iLW"><?php echo $applications;?></div>
            <div class="Home_HomeSpace__2q0OU"></div>
            <a href="/bookmarks">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_">Bookmarks</h2>
            </a>
            <div class="BookmarkGrid_BookmarkGrid__26LlR">
              <div class="BookmarkCard_BookmarkCard__1GmHc">
                <h3 class="">Amazon</h3>
                <div class="BookmarkCard_Bookmarks__YhsfD">
                  <a href="https://console.aws.amazon.com" target="_blank" rel="noreferrer">AWS Console</a>
                  <a href="https://horwood.awsapps.com/start" target="_blank" rel="noreferrer">AWS SSO login</a>
                  <a href="https://smile.amazon.co.uk" target="_blank" rel="noreferrer">Shop</a>
                </div>
              </div>
            </div>
            <a class="Home_SettingsButton__Qvn8C" href="/settings">
              svg icon here
            </a>
          </div>
        </div>
    </body>
</html>
