<?php declare(strict_types=1);

use Liamja\Cex\Box;
use Liamja\Cex\CexClient;
use Liamja\Cex\NearestStore;
use Liamja\Cex\PredictiveSearchResult;
use Liamja\Cex\SearchParameters;

class CexClientTest extends \PHPUnit\Framework\TestCase
{
    public function testSearchBoxes()
    {
        $cex = new CexClient();

        $searchParameters = new SearchParameters();
        $searchParameters->setSearchTerm('Super Mario Bros');

        $boxes = $cex->searchBoxes($searchParameters);

        $this->assertInstanceOf(Box::class, $boxes[0]);
    }

    public function testSearchNearestStores()
    {
        $cex = new CexClient();

        $stores = $cex->searchNearestStores(1.2973550000000387, 52.6308859);

        $this->assertInstanceOf(NearestStore::class, $stores[0]);
    }

    public function testPredictiveSearch()
    {
        $cex = new CexClient();

        $searchParameters = new SearchParameters();
        $searchParameters->setSearchTerm('Super Mario Bros');

        $results = $cex->predictiveSearch($searchParameters);

        $this->assertInstanceOf(PredictiveSearchResult::class, $results[0]);
    }
}
