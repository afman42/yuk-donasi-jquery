<style>
table {
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
}
</style>

<h1>Pengguna Penggalang Dana</h1>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Username</th> 
    </tr>
  </thead>
  <tbody>
    @forelse($data as $penggalang)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $penggalang->username }}</td>
        </tr>
    @empty
        <p>Tidak ada pengguna penggalang</p>
    @endforelse
  </tbody>
</table>