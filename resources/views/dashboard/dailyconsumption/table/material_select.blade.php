<select>
    <option value="">Select Item</option>
    @foreach ($budgetItems as $budgetItem)
    @php
        $material = $budgetItem->materialInfo();
    @endphp
    <option value="{{ $budgetItem->id }}"   @if ($material) material-id="{{ $material->id }}" @endif>
        {{ $budgetItem->name }}
        @if ($material)
            ({{ $material->materialUnit->name }})
        @endif
    </option>
    @endforeach
</select>
