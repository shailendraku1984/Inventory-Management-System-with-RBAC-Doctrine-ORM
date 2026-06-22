<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    Bus Seat Layout
                </h3>

                <p class="text-muted mb-0">
                    Real-Time Seat Booking Simulation
                </p>
            </div>

            <div>
                <span class="badge bg-success">Available</span>
                <span class="badge bg-danger">Booked</span>
            </div>

        </div>

        <div class="row g-3">

            <?php foreach ($seats as $seat): ?>

                <?php

                    $seatClass = 'seat-available';

                    if ($seat['status'] === 'booked') {
                        $seatClass = 'seat-booked';
                    }

                ?>

                <div class="col-3">

                    <div
                        class="seat <?= $seatClass ?>"
                        data-seat-id="<?= $seat['id'] ?>"
                    >
                        <?= esc($seat['seat_no']) ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>