<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Blog List</h2>
        <ul id="blogList"></ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/post/auth/get",
                type: "GET",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    var blogList = response.data.postLists;

                    if (blogList.length > 0) {
                        for (var i = 0; i < blogList.length; i++) {
                            var blog = blogList[i];
                            var listItem = '<li>' +
                                '<strong>Title:</strong> ' + blog.title +
                                ' | <strong>Category:</strong> ' + blog.category +
                                ' | <button class="btn btn-primary eye-btn" data-post-id="' + blog.id + '">View Details</button>' +
                                '</li>';
                            $("#blogList").append(listItem);
                        }
                    } else {
                        $("#blogList").append('<li>No blogs available</li>');
                    }
                },
                error: function(error) {
                    alert("Failed to fetch blog data.");
                }
            });

            $(document).on('click', '.eye-btn', function() {
                var postId = $(this).data('post-id');
                $.ajax({
                    url: "/post/auth/get/" + postId,
                    type: "GET",
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function(response) {
                        var detail = response.data.detail;
                        var tags = detail.tags.join(', ');

                        var detailsHtml = '<div>' +
                            '<strong>Date:</strong> ' + detail.date +
                            '<br><strong>Time:</strong> ' + detail.time +
                            '<br><strong>Description:</strong> ' + detail.desc +
                            '<br><strong>Tags:</strong> ' + tags +
                            '</div>';

                        alert(detailsHtml);
                    },
                    error: function(error) {
                        alert("Failed to fetch blog details.");
                    }
                });
            });
        });
    </script>
</body>
</html>
