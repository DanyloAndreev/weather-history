<div class="links">
    {{ 'Kyiv' }} - {{ 'Ukraine' }}
    <br>
    {{ $forecast->lat }}, {{ $forecast->lon }}
    <br>
    @if (is_object($forecast->current))
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Weather</th>
                <th scope="col">Hour</th>
                <th scope="col">Temperature</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">
                    <img width=24 src="{{ 'http://openweathermap.org/img/wn/' . $forecast->current->weather[0]->icon . '@2x.png' }}">
                </th>
                <td>{{ $forecast->current->weather[0]->main }}</td>
                <td>{{ Carbon\Carbon::createFromTimestamp($forecast->current->dt)->toDateTimeString() }}</td>
                <td> {{ $forecast->current->temp }}&deg;</td>
            </tr>
            </tbody>
        </table>
    @else
        <li>Sorry my dear friend, no forecast here.</li>
    @endif

</div>
