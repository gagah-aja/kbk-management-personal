<aside class="w-64 bg-white shadow-md min-h-screen p-5">
    <h1 class="text-2xl font-bold mb-5">Menu</h1>
    <nav>
        <ul>
            <li class="mb-2">
                <a href="{{ url('/') }}"
                    class="block py-2 px-3 rounded hover:bg-gray-200 {{ request()->is('/') ? 'bg-gray-200 font-semibold' : '' }}">Dashboard</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('cluster. ') }}"
                    class="block py-2 px-3 rounded hover:bg-gray-200 {{ request()->is('cluster*') ? 'bg-gray-200 font-semibold' : '' }}">Cluster</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('rumah.index') }}"
                    class="block py-2 px-3 rounded hover:bg-gray-200 {{ request()->is('rumah*') ? 'bg-gray-200 font-semibold' : '' }}">Rumah</a>
            </li>
        </ul>
    </nav>

    <hr class="my-4">

    <h2 class="text-xl font-semibold mb-3">Daftar Nama Cluster</h2>

    <ul>
        @php
            use App\Models\NamaCluster;
            $namaClusters = NamaCluster::all();
        @endphp

        @foreach ($namaClusters as $nc)
            <li class="mb-2">
                <a href="{{ route('cluster.index', ['nama_cluster' => $nc->id]) }}"
                    class="block py-2 px-3 rounded hover:bg-gray-200">
                    {{ $nc->nama_cluster }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>
