<div class="card p-2">
    <div class="row">
        <div class="col-md-3 col-6 d-flex">
            <img class="img-fluid" src="{{ $cashRequisition->createdby->profileImage() }}" alt="">
        </div>
        <div class="col-md-9">
            <p>Created By: {{ $cashRequisition->createdby->name }}</p>
            <p>Requisition Date: {{ $cashRequisition->created_at->format('d-m-Y') }}</p>
            <p>Budget Head Name: {{ $cashRequisition->budgethead->name }}</p>
            <p>Requisition Amount: {{ $cashRequisition->cash_amount }}</p>
            <p>Status: {{ $cashRequisition->status }}</p>
            <p>Comments: {{ $cashRequisition->comments->count() }}</p>
            <a href="{{ route('requisitioncommunication.details', $cashRequisition->id) }}" class="btn btn-primary float-right">View</a>
        </div>
    </div>
</div>
