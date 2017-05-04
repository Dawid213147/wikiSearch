Wiki app search engine
========================

1. Download / clone source from github:

    git clone https://github.com/Dawid213147/wikiSearch.git

2. Open comand line in root dir o project and run commend
'composer install' to install dependences

3. Search input is available in http://your-domain.com/web/app_dev.php

4. Bundle Name => Wiki\SearchBundle

5. Unit Tests:

    a: Test request to wiki app => wiki\src\Wiki\SearchBundle\Tests\Helper\HttpRequestSearchTest.php

    b: Test get image url from wiki api =>   wiki\src\Wiki\SearchBundle\Tests\Helper\HttpRequestImageTest.php