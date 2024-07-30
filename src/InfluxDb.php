<?php

namespace Iankibet\InfluxDb;

use Carbon\Carbon;
use Iankibet\InfluxDb\Dto\InfluxDbPoint;
use InfluxDB2\Model\DeletePredicateRequest;
use InfluxDB2\Point;
use InfluxDB2\Service\DeleteService;

class InfluxDb
{

    protected $client;
    protected $connectionConfig;
    protected $org;
    protected $bucket;
    public function __construct()
    {
        $connection = config('influxdb.default');
        $this->connection($connection);
    }

    public function connection($connection)
    {
        $connectionConfig = config('influxdb.connections.' . $connection);
        $this->connectionConfig = $connectionConfig;
        $this->client = new \InfluxDB2\Client([
            "url" => $connectionConfig['host'].':'.$connectionConfig['port'],
            "token" => $connectionConfig['token'],
            "bucket" => $connectionConfig['bucket'],
            "org" => $connectionConfig['org'],
            'precision' => $connectionConfig['precision']
        ]);
        $this->org = $connectionConfig['org'];
        $this->bucket = $connectionConfig['bucket'];
        return $this;
    }


    public function query(string $measurement,array $fields, $startParameter, $endParameter = null)
    {
        $query = sprintf('from(bucket: "%s")', $this->bucket);
        $query .= sprintf(' |> range(start: %s)', $startParameter);
        if ($endParameter) {
            $query .= ' |> range(stop: '.$endParameter.')';
        }
        $query .= sprintf(' |> filter(fn: (r) => r._measurement == "%s")', $measurement);
            foreach ($fields as $field => $value) {
                $query .= sprintf(' |> filter(fn: (r) => r.%s == "%s")', $field, $value);
            }
        $queryApi = $this->client->createQueryApi();
//            dd($query);
        $parser = $queryApi->queryStream($query);
        $records =[];
        foreach ($parser->each() as $record) {
            $records[] = $record->values;
        }
        return $records;
    }
    public function queryRaw(string $query)
    {
        // convert sql query to influxdb query
    }

    protected function deleteExisting(InfluxDbPoint $point)
    {
        $start = Carbon::createFromTimestamp($point->getTime())->subHour()->toDateTime();
        $stop = Carbon::createFromTimestamp($point->getTime())->addHours(2)->toDateTime();
        $service = $this->client->createService(DeleteService::class);

        $predicate = new DeletePredicateRequest();
        $predicate->setStart($start);
        $predicate->setStop($stop);
        $predicateString= '_measurement="'.$point->getMeasurement().'"';
        foreach ($point->getTags() as $tag => $value) {
            if (!empty($value)) { // Check if the tag value is not empty
                $predicateString .= ' AND '.$tag.'="'.$value.'"';
            }
        }
        $predicate->setPredicate($predicateString);
        $service->postDelete($predicate,null,$this->org, $this->bucket);

    }

    public function write(InfluxDbPoint $point, $deleteExisting = false)
    {
        if($deleteExisting){
            $this->deleteExisting($point);
        }
        $writeApi = $this->client->createWriteApi();
        $writeApi->write($point->toArray());
        return true;
    }

    public function writePoint(Point $point)
    {
        // TODO: Implement write() method.
    }
}
