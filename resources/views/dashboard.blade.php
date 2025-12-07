<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @role('admin')
                        <h1>Halo Admin</h1>
                    @endrole

                    @role('editor')
                        <h1>Halo Editor</h1>
                    @endrole
                    
                    @role('user')
                        <h1>Halo User</h1>
                    @endrole

                    @permission('create-post')
                        <button>Tambah</button>
                    @endpermission

                    <table>
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <td>Jahra</td>
                            <td>
                                @permission('edit-post')
                                    <button>Edit</button>
                                @endpermission

                                @permission('delete-post')
                                    <button>Hapus</button>
                                @endpermission
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <canvas id="penjualan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const ctx = document.getElementById('penjualan');

        const data1 = {
            labels: @json($namaBarang),
            datasets: [{
                    label: 'Januari',
                    data: @json($bulanJanuari),
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                },
                {
                    label: 'Februari',
                    data: @json($bulanFebruari),
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                },
                {
                    label: 'Maret',
                    data: @json($bulanMaret),
                    fill: true,
                    backgroundColor: 'rgba(28, 110, 164, 0.2)',
                    borderColor: 'rgba(28, 110, 164, 1)',
                    pointBackgroundColor: 'rgba(28, 110, 164, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(28, 110, 164, 1)'
                }
            ]
        };

        new Chart(ctx, {
            type: 'radar',
            data: data1,
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>
