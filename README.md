ArraySearch
===================

This function is searching inside of array.

Example Usage:
```php
<?php

include('ArraySearch.php');

$query		=	"a='Example World' and b>='2'";

$Array			=	array(
    'a' => array('d' => '2'),
    array('a' => 'Example World','b' => '2'),
    array('c' => '3'),
    array('d' => '4'),
);

$Result = ArraySearch($Array,$query,1);

echo '<pre>';
print_r($Result);
echo '</pre>';

// Output:
// Array
// (
//    [0] => Array
//        (
//            [a] => Example World
//            [b] => 2
//        )
//
// )
?>
```
