<?php
require_once './functions.php';

$airports = require './airports.php';

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 */

$filter_by_first_letter = $_GET['filter_by_first_letter'];
if($filter_by_first_letter){
    $airports = filterFirstLetter($airports, $filter_by_first_letter);
}

function filterFirstLetter(array $arr, string $chr): array
{
    return array_values( array_filter($arr, function ($val) use($chr) {return $val['name'][0] == $chr;} ));
}

$filter_by_state = $_GET['filter_by_state'];
if($filter_by_state){
    $airports = filterState($airports, $filter_by_state);
}

function filterState(array $arr, string $chr): array
{
    return array_values( array_filter($arr, function ($val) use($chr) {return $val['state'] == $chr;} ));
}

$filter_sort = $_GET['sort'];
if(isset($filter_sort)) {
    switch ($filter_sort) {
        case 'name':
            usort( $airports, function ($a, $b) {return $a['name'] <=> $b['name'];});
            break;
        case 'code':
            usort($airports, function ($a, $b) {return $a['code'] <=> $b['code'];});
            break;
        case 'state':
            usort($airports, function ($a, $b) {return $a['state'] <=> $b['state'];});
            break;
        case 'city':
            usort($airports, function ($a, $b) {return $a['city'] <=> $b['city'];});
            break;
    }
}




// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */



$page = $_GET['page'] ?? 1;
if($page < 1) {$page = 1;}

$items_per_page = 10;
$num_airports = count($airports);
$num_pages = (int) ceil($num_airports / $items_per_page);

$airports = array_chunk($airports, $items_per_page)[$page-1];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        .page-item .active {
            background-color: #047bfe;
            color: #fff;
        }
    </style>
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(require './airports.php') as $letter): ?>
            <!--            <a href="/?--><? //= (!empty($_GET['filter_by_state'])) ? "filter_by_first_letter={$letter}&filter_by_state={$_GET['filter_by_state']}" : "?filter_by_first_letter={$letter}"; ?><!--">--><? //= $letter ?><!--</a>-->
            <a href="/?<?= (!empty($_GET['page'])) ? "page={$_GET['page']}&" : ''; ?>filter_by_first_letter=<?= $letter ?><?= (!empty($_GET['filter_by_state'])) ? "&filter_by_state={$_GET['filter_by_state']}" : ''; ?><?= (!empty($_GET['sort'])) ? "&sort={$_GET['sort']}" : ''; ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <?php

    function sorting(string $sort)
    {
        $urlArr = [];
        $url = $_SERVER['QUERY_STRING'];
        parse_str($url, $urlArr);

        $urlArr['sort'] = $sort;
        $url = http_build_query($urlArr);
        return $url;
    }

    ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="/?<?= sorting('name') ?>">Name</a></th>
            <th scope="col"><a href="/?<?= sorting('code') ?>">Code</a></th>
            <th scope="col"><a href="/?<?= sorting('state') ?>">State</a></th>
            <th scope="col"><a href="/?<?= sorting('city') ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php if($airports):?>
        <?php foreach ($airports as $airport): ?>
            <tr>
                <td><?= $airport['name'] ?></td>
                <td><?= $airport['code'] ?></td>
                <td>
                    <a href="/?<?= (!empty($_GET['page'])) ? "page={$_GET['page']}&" : ''; ?><?= (!empty($_GET['filter_by_first_letter'])) ? "filter_by_first_letter={$_GET['filter_by_first_letter']}&" : ""; ?>filter_by_state=<?= $airport['state'] ?><?= (!empty($_GET['sort'])) ? "&sort={$_GET['sort']}" : ''; ?>"><?= $airport['state'] ?></a>
                </td>
                <td><?= $airport['city'] ?></td>
                <td><?= $airport['address'] ?></td>
                <td><?= $airport['timezone'] ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else:?>
            <p>Результатів не знайдено...</p>
        <?php endif;?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->

    <?php

    function pagination($page){
        $urlArr = [];
        $url = $_SERVER['QUERY_STRING'];
        parse_str($url, $urlArr);

        $arrPaginate = ['page' => $page];
        $urlArr = $arrPaginate + $urlArr;

        $url = http_build_query($urlArr);
        return $url;
    }

    $i_min = max(1, $page - 3);
    $i_max = min($i_min + 6, $num_pages);
    $i_min = max(1, $i_max - 6);

    $requestGet = $url = $_SERVER['QUERY_STRING'];
    ?>

    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = $i_min; $i <= $i_max; $i++):?>
                <?php $paginateUrl = pagination($i);?>
                <li class="page-item">
                    <?= ($i != $page) ? "<a class='page-link' href='/?{$paginateUrl}'>{$i}</a>" : "<span class='page-link active'>{$i}</span>" ?>
                </li>
            <?php endfor;?>
        </ul>
    </nav>





</main>
</html>
