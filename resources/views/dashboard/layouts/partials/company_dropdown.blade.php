@php
    use App\Models\Company;
    $companies = Company::select(['id', 'name'])->get();
@endphp

@if (auth()->user()->hasRole('Software Admin'))
    <div class="{{ $columnClass }}">
        <div class="form-group">
            <label for="">Company</label>
            <select name="company" id="company" class="select2" required>
                <option value="">Select Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if ($company_id == $company->id) selected @endif>
                        {{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

@endif
