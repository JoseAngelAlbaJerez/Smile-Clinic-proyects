@foreach($patients as $patient)
    <tr>
        <th scope="row">{{ $patient->pacient_id }}</th>
        <td>{{ $patient->name }}</td>
        <td>{{ $patient->age }}</td>
        <td>{{ $patient->ars }}</td>
        <td>{{ $patient->motive }}</td>
    </tr>
@endforeach