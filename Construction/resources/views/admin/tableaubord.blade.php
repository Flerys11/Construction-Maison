@extends('base')
    @section('content')

        <div class="content px-3">


            <div class="clearfix"></div>
            <div class="row">
                        @include('admin.stat')
                <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                        <div class="container ">
                            <div class="start-0">

                                <h3>Histogramme En Mois</h3>
                            </div>
                            <div class="end-0">
                                <div class="form-group col-sm-6">
                                  <form action="{{ route('date.chart') }}" method="POST">
                                      @csrf
                                      <select class="form-control" name="annee" onchange="this.form.submit()">
                                          @foreach($stat_annee as $stat_annees)
                                              <option value="">Trie par Année</option>
                                              <option value="{{ $stat_annees->year_month }}">{{$stat_annees->year_month}}</option>
                                          @endforeach

                                      </select>
                                  </form>

                                </div>
                           </div>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                id="cardOpt1"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>

                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Transactions</span>
                                    <h3 class="card-title mb-2">{{ $total_paiement[0]->total_p }} Ar</h3>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var data = @json($stat_mois);
            function formatDate(dateString) {
                var date = new Date(dateString);
                date.setMonth(date.getMonth() + 1);
                date.setDate(0);
                var formattedDate = date.toISOString().split('T')[0];

                return formattedDate;
            }

            var labels = data.map(item => formatDate(item.month));
            var totalPrix = data.map(item => parseFloat(item.total_prix));
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Prix',
                        data: totalPrix,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endsection
