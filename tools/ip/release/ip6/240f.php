<?php

/**
 * @Project NUKEVIET 4.x
 * @This product includes GeoLite2 data created by MaxMind, available from http://www.maxmind.com
 * @Createdate Fri, 08 Jun 2018 08:58:59 GMT
 */

$ranges = array('240f::/30'=>'JP','240f:4::/33'=>'JP','240f:4:8000::/34'=>'JP','240f:4:c000::/39'=>'JP','240f:4:c200::/40'=>'JP','240f:4:c300::/41'=>'JP','240f:4:c380::/42'=>'JP','240f:4:c3c0::/44'=>'JP','240f:4:c3d0::/45'=>'JP','240f:4:c3d8::/46'=>'JP','240f:4:c3dc::/49'=>'US','240f:4:c3dc:8000::/49'=>'JP','240f:4:c3dd::/48'=>'JP','240f:4:c3de::/47'=>'JP','240f:4:c3e0::/43'=>'JP','240f:4:c400::/38'=>'JP','240f:4:c800::/37'=>'JP','240f:4:d000::/36'=>'JP','240f:4:e000::/35'=>'JP','240f:5::/32'=>'JP','240f:6::/37'=>'JP','240f:6:800::/42'=>'JP','240f:6:840::/45'=>'JP','240f:6:848::/47'=>'JP','240f:6:84a::/49'=>'US','240f:6:84a:8000::/49'=>'JP','240f:6:84b::/48'=>'JP','240f:6:84c::/46'=>'JP','240f:6:850::/44'=>'JP','240f:6:860::/43'=>'JP','240f:6:880::/41'=>'JP','240f:6:900::/40'=>'JP','240f:6:a00::/39'=>'JP','240f:6:c00::/38'=>'JP','240f:6:1000::/36'=>'JP','240f:6:2000::/35'=>'JP','240f:6:4000::/34'=>'JP','240f:6:8000::/33'=>'JP','240f:7::/32'=>'JP','240f:8::/37'=>'JP','240f:8:800::/38'=>'JP','240f:8:c00::/39'=>'JP','240f:8:e00::/41'=>'JP','240f:8:e80::/42'=>'JP','240f:8:ec0::/43'=>'JP','240f:8:ee0::/44'=>'JP','240f:8:ef0::/46'=>'JP','240f:8:ef4::/49'=>'US','240f:8:ef4:8000::/49'=>'JP','240f:8:ef5::/48'=>'JP','240f:8:ef6::/47'=>'JP','240f:8:ef8::/45'=>'JP','240f:8:f00::/40'=>'JP','240f:8:1000::/36'=>'JP','240f:8:2000::/35'=>'JP','240f:8:4000::/34'=>'JP','240f:8:8000::/33'=>'JP','240f:9::/32'=>'JP','240f:a::/31'=>'JP','240f:c::/30'=>'JP','240f:10::/30'=>'JP','240f:14::/34'=>'JP','240f:14:4000::/36'=>'JP','240f:14:5000::/37'=>'JP','240f:14:5800::/38'=>'JP','240f:14:5c00::/39'=>'JP','240f:14:5e00::/40'=>'JP','240f:14:5f00::/41'=>'JP','240f:14:5f80::/42'=>'JP','240f:14:5fc0::/43'=>'JP','240f:14:5fe0::/44'=>'JP','240f:14:5ff0::/46'=>'JP','240f:14:5ff4::/48'=>'JP','240f:14:5ff5::/49'=>'GB','240f:14:5ff5:8000::/49'=>'JP','240f:14:5ff6::/47'=>'JP','240f:14:5ff8::/45'=>'JP','240f:14:6000::/35'=>'JP','240f:14:8000::/33'=>'JP','240f:15::/32'=>'JP','240f:16::/31'=>'JP','240f:18::/29'=>'JP','240f:20::/28'=>'JP','240f:30::/32'=>'JP','240f:31::/34'=>'JP','240f:31:4000::/35'=>'JP','240f:31:6000::/36'=>'JP','240f:31:7000::/42'=>'JP','240f:31:7040::/43'=>'JP','240f:31:7060::/44'=>'JP','240f:31:7070::/45'=>'JP','240f:31:7078::/46'=>'JP','240f:31:707c::/47'=>'JP','240f:31:707e::/49'=>'GB','240f:31:707e:8000::/49'=>'JP','240f:31:707f::/48'=>'JP','240f:31:7080::/41'=>'JP','240f:31:7100::/40'=>'JP','240f:31:7200::/39'=>'JP','240f:31:7400::/38'=>'JP','240f:31:7800::/37'=>'JP','240f:31:8000::/33'=>'JP','240f:32::/31'=>'JP','240f:34::/30'=>'JP','240f:38::/29'=>'JP','240f:40::/27'=>'JP','240f:60::/28'=>'JP','240f:70::/32'=>'JP','240f:71::/37'=>'JP','240f:71:800::/40'=>'JP','240f:71:900::/42'=>'JP','240f:71:940::/43'=>'JP','240f:71:960::/44'=>'JP','240f:71:970::/45'=>'JP','240f:71:978::/48'=>'JP','240f:71:979::/49'=>'KR','240f:71:979:8000::/49'=>'JP','240f:71:97a::/47'=>'JP','240f:71:97c::/46'=>'JP','240f:71:980::/41'=>'JP','240f:71:a00::/39'=>'JP','240f:71:c00::/38'=>'JP','240f:71:1000::/36'=>'JP','240f:71:2000::/35'=>'JP','240f:71:4000::/34'=>'JP','240f:71:8000::/33'=>'JP','240f:72::/31'=>'JP','240f:74::/31'=>'JP','240f:76::/32'=>'JP','240f:77::/36'=>'JP','240f:77:1000::/37'=>'JP','240f:77:1800::/40'=>'JP','240f:77:1900::/45'=>'JP','240f:77:1908::/48'=>'JP','240f:77:1909::/49'=>'CN','240f:77:1909:8000::/49'=>'JP','240f:77:190a::/47'=>'JP','240f:77:190c::/46'=>'JP','240f:77:1910::/44'=>'JP','240f:77:1920::/43'=>'JP','240f:77:1940::/42'=>'JP','240f:77:1980::/41'=>'JP','240f:77:1a00::/39'=>'JP','240f:77:1c00::/38'=>'JP','240f:77:2000::/35'=>'JP','240f:77:4000::/34'=>'JP','240f:77:8000::/33'=>'JP','240f:78::/35'=>'JP','240f:78:2000::/36'=>'JP','240f:78:3000::/41'=>'JP','240f:78:3080::/43'=>'JP','240f:78:30a0::/44'=>'JP','240f:78:30b0::/47'=>'JP','240f:78:30b2::/49'=>'CN','240f:78:30b2:8000::/49'=>'JP','240f:78:30b3::/48'=>'JP','240f:78:30b4::/46'=>'JP','240f:78:30b8::/45'=>'JP','240f:78:30c0::/42'=>'JP','240f:78:3100::/40'=>'JP','240f:78:3200::/39'=>'JP','240f:78:3400::/38'=>'JP','240f:78:3800::/37'=>'JP','240f:78:4000::/34'=>'JP','240f:78:8000::/33'=>'JP','240f:79::/32'=>'JP','240f:7a::/31'=>'JP','240f:7c::/30'=>'JP','240f:80::/28'=>'JP','240f:90::/29'=>'JP','240f:98::/33'=>'JP','240f:98:8000::/37'=>'JP','240f:98:8800::/38'=>'JP','240f:98:8c00::/39'=>'JP','240f:98:8e00::/40'=>'JP','240f:98:8f00::/42'=>'JP','240f:98:8f40::/43'=>'JP','240f:98:8f60::/44'=>'JP','240f:98:8f70::/45'=>'JP','240f:98:8f78::/49'=>'SE','240f:98:8f78:8000::/49'=>'JP','240f:98:8f79::/48'=>'JP','240f:98:8f7a::/47'=>'JP','240f:98:8f7c::/46'=>'JP','240f:98:8f80::/41'=>'JP','240f:98:9000::/36'=>'JP','240f:98:a000::/35'=>'JP','240f:98:c000::/34'=>'JP','240f:99::/32'=>'JP','240f:9a::/31'=>'JP','240f:9c::/30'=>'JP','240f:a0::/28'=>'JP','240f:b0::/30'=>'JP','240f:b4::/32'=>'JP','240f:b5::/35'=>'JP','240f:b5:2000::/38'=>'JP','240f:b5:2400::/40'=>'JP','240f:b5:2500::/43'=>'JP','240f:b5:2520::/48'=>'JP','240f:b5:2521::/49'=>'US','240f:b5:2521:8000::/49'=>'JP','240f:b5:2522::/47'=>'JP','240f:b5:2524::/46'=>'JP','240f:b5:2528::/45'=>'JP','240f:b5:2530::/44'=>'JP','240f:b5:2540::/42'=>'JP','240f:b5:2580::/41'=>'JP','240f:b5:2600::/39'=>'JP','240f:b5:2800::/37'=>'JP','240f:b5:3000::/36'=>'JP','240f:b5:4000::/34'=>'JP','240f:b5:8000::/33'=>'JP','240f:b6::/31'=>'JP','240f:b8::/29'=>'JP','240f:c0::/28'=>'JP','240f:d0::/32'=>'JP','240f:d1::/33'=>'JP','240f:d1:8000::/34'=>'JP','240f:d1:c000::/37'=>'JP','240f:d1:c800::/39'=>'JP','240f:d1:ca00::/40'=>'JP','240f:d1:cb00::/41'=>'JP','240f:d1:cb80::/42'=>'JP','240f:d1:cbc0::/45'=>'JP','240f:d1:cbc8::/48'=>'JP','240f:d1:cbc9::/49'=>'AU','240f:d1:cbc9:8000::/49'=>'JP','240f:d1:cbca::/47'=>'JP','240f:d1:cbcc::/46'=>'JP','240f:d1:cbd0::/44'=>'JP','240f:d1:cbe0::/43'=>'JP','240f:d1:cc00::/38'=>'JP','240f:d1:d000::/36'=>'JP','240f:d1:e000::/35'=>'JP','240f:d2::/31'=>'JP','240f:d4::/30'=>'JP','240f:d8::/29'=>'JP','240f:e0::/27'=>'JP','240f:100::/24'=>'JP','240f:8000::/24'=>'CN');
