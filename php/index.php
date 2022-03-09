<?php
    $image = 'https://siemens.mindsphere.io/en/partner/partner-profiles/tech-mahindra/_jcr_content/root/container/division/content/teaser/container/image.coreimg.82.320.png/1549992773121/techmahindra-logo.png';
    $imageData = base64_encode(file_get_contents($image));
    echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
    echo "<br>"."Hello TechM University from my docker laboratory new container!!!";
?>