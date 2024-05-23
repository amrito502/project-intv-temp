@foreach ($materials as $material)
<tr>
    <td>{{ $material->name }} ({{ $material->materialUnit->name }})</td>
    <td>
        <input type="number" step="any" class="form-control" name="materials[{{ $material->id }}]" value="0">
    </td>
</tr>
@endforeach
