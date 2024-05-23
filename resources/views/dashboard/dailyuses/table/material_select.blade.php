<select>
    <option value="">Select Item</option>
    @foreach ($budgetItems as $budgetItem)
    <option value="{{ $budgetItem->budgetHead->id }}">{{ $budgetItem->budgetHead->name }}</option>
    @endforeach
</select>
