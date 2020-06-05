<style>
    table {
      border-collapse: collapse;
    }
    
    table, th, td {
      border: 1px solid black;
    }
    </style>
    
  <h1>Judul: {{ $data[0]->judul }}</h1>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Username donatur</th>
          <th>Masukan Donasi</th>
        </tr>
      </thead>
      <tbody>
        @php
            $jumlah = 0;
        @endphp
        @forelse($data as $posting)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $posting->username }}
                <td>{{ $posting->donasi_masuk }}</td>
            </tr>
            @php
            $jumlah += $posting->donasi_masuk                
            @endphp
        @empty
            <p>Tidak ada Donasi</p>
        @endforelse
            
            <tr>
                <td colspan="2">Jumlah Donasi Terkumpul</td>
                <td>{{ $jumlah }}</td>
            </tr>
      </tbody>
    </table>
