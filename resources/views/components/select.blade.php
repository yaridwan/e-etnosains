@props(['label' => null, 'name', 'wajib' => false, 'opsi' => [], 'placeholder' => 'Pilih...'])

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }} @if($wajib)<span class="text-rose-600">*</span>@endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 ' .
                ($errors->has($name) ? 'border-rose-400 focus:ring-rose-500' : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600')
        ]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($opsi as $nilai => $label_opsi)
            <option value="{{ $nilai }}" @selected(old($name, $attributes->get('selected')) == $nilai)>{{ $label_opsi }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
