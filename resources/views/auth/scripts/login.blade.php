<script>
    $(document).ready(function() {
        let secondsUntilNextAttempt = {{ $secondsUntilNextAttempt ?? 'null' }};
        console.log(secondsUntilNextAttempt);

        if (secondsUntilNextAttempt > 0) {
            $('#loginForm').hide();
            $('#throttle-timer').show();
            startTimer(secondsUntilNextAttempt);
        }

        // Handle the login form submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            // Show loading spinner with SweetAlert
            Swal.fire({
                title: 'Logging in...',
                text: 'Please wait a moment.',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading(); // Show the loading spinner
                }
            });

            // Send login request via AJAX
            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Close the loading Swal
                    Swal.close();

                    // Handle successful login
                    if (response.message === "Login successful") {
                        window.location.href =
                            '{{ route('main.dashboard.index') }}'; // Redirect to dashboard
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    // Close the loading Swal
                    Swal.close();

                    // Handle different error status codes and responses
                    if (xhr.status === 429) {
                        let retryAfter = xhr.responseJSON.retry_after;
                        console.log('Retry after: ' + retryAfter);

                        Swal.fire('Too many attempts!', 'Please wait and try again later.',
                            'error');
                        $('#loginForm').hide();
                        $('#throttle-timer').show();
                        startTimer(retryAfter);
                    } else if (xhr.status === 401) {
                        Swal.fire('Login failed!', 'Invalid credentials. Please try again.',
                            'error');
                    } else if (xhr.status === 403) {
                        Swal.fire('Account Inactive',
                            'Your account is inactive. Please contact support.',
                            'warning');
                    } else {
                        Swal.fire('Error',
                            'An unexpected error occurred. Please try again later.',
                            'error');
                    }
                }
            });
        });

        // Function to start countdown timer for retry attempts
        function startTimer(seconds) {
            let timer = seconds;
            let interval = setInterval(function() {
                $('#timer').text(timer); // Update the countdown timer text
                if (timer <= 0) {
                    clearInterval(interval);
                    $('#loginForm').show();
                    $('#loginForm')[0].reset();
                    $('#throttle-timer').hide();
                }
                timer--; // Decrease the timer by 1 every second
            }, 1000);
        }
    });
</script>
