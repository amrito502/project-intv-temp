<?php
namespace App\Helper;

use App\Models\MemberSale;

class MemberSaleHistoryReport{

    protected $params;
    protected $queryData;

    public function __construct($params)
    {
        $this->params = $params;
        $this->getData();
    }

    public function getData()
    {
        $memberSale = MemberSale::with('customer', 'dealer','items', 'items.product', 'items.product.category')
        ->whereDate('invoice_date', '>=', $this->params['dateRange']['start_date'])
        ->whereDate('invoice_date', '<=', $this->params['dateRange']['end_date']);

        if($this->params["dealers"]){
            $memberSale->whereIn('store_id', $this->params["dealers"]);
        }

        if($this->params["members"]){
            $memberSale->whereIn('customer_id', $this->params["members"]);
        }

        $memberSale = $memberSale->get();

        $this->queryData = $memberSale;

    }

    public function getReport()
    {
        return $this->queryData;
    }
}
