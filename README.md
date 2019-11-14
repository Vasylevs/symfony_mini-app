ROUTE STRUCTURE
-------------------

      /api/user [POST(action=top_user_sum_order||no_success_order)] 
      /api/order [POST(action=top_order_work_day)]

action=top_user_sum_order --> top 500 users with the maximum total number (order status must be successful)
action=no_success_order --> top 500 users over the past year who have no orders with success status, sorted by registration date
action=top_order_work_day --> top 500 orders created on a weekday in the last 3 months (print orderid, email, date), sorted by order date


CONSOLE COMMAND
------------

      app:create-user  $var   generate rand user ($var count generate, default 500)
      app:create-order $var   generate rand order for user ($var count generate, default 500)