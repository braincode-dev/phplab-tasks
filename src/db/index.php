<?php
/**
 * Connect to DB
 */
require_once './pdo_ini.php';

$limit = 10;
$starting_limit = 0;
$sqlParams = [
    "SELECT a.id, a.name, a.code, s.name as state_name, c.name as city_name, a.address, a.timezone",
    "FROM `airports` a",
    "INNER JOIN cities c",
    "ON a.city_id = c.id",
    "INNER JOIN states s",
    "ON a.state_id = s.id",
];

if(!empty($_GET['filter_by_first_letter'])){
    $filter_by_first_letter = $_GET['filter_by_first_letter'];
    array_push($sqlParams, "WHERE a.name LIKE '$filter_by_first_letter%'");

    //  Another way :)
    //  $r->bindValue(':letter', $filter_by_first_letter.'%', PDO::PARAM_INT);
    //  $r->execute(['letter' => $filter_by_first_letter.'%']);
}

if(!empty($_GET['filter_by_state'])){
    $filter_by_state = $_GET['filter_by_state'];
    array_push($sqlParams, "AND s.name = '$filter_by_state'");
}

if(!empty($_GET['sort'])){
    $sort = $_GET['sort'];

    switch ($sort) {
        case 'name':
            $sort = "a.$sort";
            break;
        case 'code':
            $sort = "a.$sort";
            break;
        case 'state':
            $sort = "s.name";
            break;
        case 'city':
            $sort = "c.name";
            break;
    }
    array_push($sqlParams, "ORDER BY $sort");
}

$sqlCountArr = $sqlParams;
array_push($sqlParams, "LIMIT $starting_limit, $limit");

$sql = '';
foreach ($sqlParams as $value){
    $sql .= $value . ' ';
}

$r = $pdo->prepare($sql);
$r->setFetchMode(\PDO::FETCH_ASSOC);
$r->execute();
$result = $r->fetchAll();

// pagination init
$sqlCount = '';
foreach ($sqlCountArr as $value){
    $sqlCount .= $value . ' ';
}

$c = $pdo->query($sqlCount);
$c->execute();
$total_results = count($c->fetchAll());
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}

$starting_limit = ($page-1)*$limit;


/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
$sqlFirstLetters = "SELECT DISTINCT LEFT(name, 1) as letter FROM airports ORDER BY letter";
$queryFirstLetters = $pdo->query($sqlFirstLetters);
$uniqueFirstLetters = $queryFirstLetters->fetchAll(PDO::FETCH_COLUMN, 0);

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */

/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$airports = $result;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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

        <?php foreach ($uniqueFirstLetters as $letter): ?>
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
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="/?<?= (!empty($_GET['page'])) ? "page={$_GET['page']}&" : ''; ?><?= (!empty($_GET['filter_by_first_letter'])) ? "filter_by_first_letter={$_GET['filter_by_first_letter']}&" : ""; ?>filter_by_state=<?= $airport['state_name'] ?><?= (!empty($_GET['sort'])) ? "&sort={$_GET['sort']}" : ''; ?>"><?= $airport['state_name'] ?></a></td>
            <td><?= $airport['city_name'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
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
    $i_max = min($i_min + 6, $total_pages);
    $i_min = max(1, $i_max - 6);

    $requestGet = $url = $_SERVER['QUERY_STRING'];

    if(!empty($_GET['page'])){
        $active = $_GET['page'];
    }else{
        $active = 1;
    }
    ?>

    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = $i_min; $i <= $i_max; $i++):?>
                <?php $paginateUrl = pagination($i);?>
                <li class="page-item <?=($i == $active) ? 'active' : '' ?>">
                    <?= ($i != $page) ? "<a class='page-link' href='/?{$paginateUrl}'>{$i}</a>" : "<span class='page-link active'>{$i}</span>" ?>
                </li>
            <?php endfor;?>
        </ul>
    </nav>

</main>
</html>
