@props(['status'])

@php($status = $status instanceof \App\Enums\StatusPublikasi ? $status : \App\Enums\StatusPublikasi::from($status))

<x-badge :warna="$status->warnaBadge()">{{ $status->label() }}</x-badge>
