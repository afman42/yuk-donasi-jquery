<style>
table {
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
}
</style>

<h1>Pengguna Donatur</h1>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Username</th> 
    </tr>
  </thead>
  <tbody>
    @forelse($data as $donatur)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $donatur->username }}</td>
        </tr>
    @empty
        <p>Tidak ada pengguna donatur</p>
    @endforelse
  </tbody>
</table>