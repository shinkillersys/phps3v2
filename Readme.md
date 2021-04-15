If you haven't already:

Install Composer:

    sudo apt install composer

Install PHP, Mbstring PHP Extension:

    sudo apt install php7.4 php7.4-mbstring php7.4-xml

Install AWS SDK:

    composer require aws/aws-sdk-php

Run:

    UpLoad File:

        php index.php

    Delete File:

        php delete.php
    
    UpLoad Folder using Foreach:

        php folder.php

    UpLoad Folder using AWS Transfer:

        php sync.php


