<script>
    $(document).ready(function() {
        let secondsUntilNextAttempt = {{ $secondsUntilNextAttempt ?? 'null' }};
        console.log(secondsUntilNextAttempt);


        if (secondsUntilNextAttempt > 0) {
            $('#loginForm').hide();
            $('#throttle-timer').show();
            startTimer(secondsUntilNextAttempt);
        }

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire('Login successful!');
                    window.location.href = '{{ route('main.dashboard.index') }}';
                },
                error: function(xhr) {
                    if (xhr.status === 429) {
                        let retryAfter = xhr.responseJSON.retry_after;
                        console.log(retryAfter);

                        Swal.fire('Too many attempts!', 'Please wait and try again later.',
                            'error');
                        $('#loginForm').hide();
                        $('#throttle-timer').show();
                        startTimer(retryAfter);
                        location.reload(); // Reload tabel jika perlu
                    } else if (xhr.status === 401) {
                        Swal.fire('Login failed!', 'Invalid credentials', 'error');
                    }
                }
            });
        });

        function startTimer(seconds) {
            let timer = seconds;
            let interval = setInterval(function() {
                $('#timer').text(timer);
                if (timer <= 0) {
                    clearInterval(interval);
                    $('#loginForm').show();
                    $('#throttle-timer').hide();
                }
                timer--;
            }, 1000);
        }
    });
</script>
