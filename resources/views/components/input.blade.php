@props(['label' => null, 'name', 'type' => 'text', 'wajib' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }} @if($wajib)<span class="text-rose-600">*</span>@endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $attributes->get('value')) }}"
        {{ $attributes->except('value')->merge([
            'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 ' .
                ($errors->has($name) ? 'border-rose-400 focus:ring-rose-500' : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600')
        ]) }}
    >

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
