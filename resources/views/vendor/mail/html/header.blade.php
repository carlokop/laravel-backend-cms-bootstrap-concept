<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Logo')
<img src="" class="logo" alt="Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
