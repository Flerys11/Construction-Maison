
<div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
    <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Statistique Devis annuelle</h5>
                <small class="text-muted"></small>
            </div>
            <div class="dropdown">
                <button
                    class="btn p-0"
                    type="button"
                    id="orederStatistics"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
            </div>
        </div>
        @php
            $totalPrixTotal = 0;
        @endphp
        @foreach($total_devis as $total_deviss)
            @php
                $totalPrixTotal += $total_deviss->total_prix;
            @endphp
        @endforeach
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column align-items-center gap-1">
                    <h2 class="mb-2">{{ $totalPrixTotal}} Ar</h2>
                    <span>Total Devis</span>
                </div>
                <div id="orderStatisticsChart"></div>
            </div>
            <ul class="p-0 m-0">
                @foreach($stat_annee as $stat_annees)
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Annee : {{ $stat_annees->year_month }}</h6>
                                <small class="text-muted"></small>
                            </div>
                            <div class="user-progress">
                                <small class="fw-semibold">{{ $stat_annees->total_prix }} Ar</small>
                            </div>
                        </div>
                    </li>
                @endforeach


            </ul>
        </div>
    </div>
</div>
