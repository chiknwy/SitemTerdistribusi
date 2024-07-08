<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        div.dataTables_wrapper div.dataTables_filter input {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_length label {
            color: #60a5fa;
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 4px;
            padding: 4px;
            outline: none;
        }

        #myTable_paginate {
            margin-top: 10px;
        }

        #myTable_previous,
        #myTable_next {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 4px;
            padding: 8px 12px;
            margin-right: 5px;
            cursor: pointer;
        }

        #myTable_previous:hover,
        #myTable_next:hover {
            background-color: #333;
        }

        #myTable_paginate .paginate_button:not(:last-child),
        #myTable_paginate .paginate_button:last-child {
            margin-right: 10px;
        }

        #myTable {
            border: 1px solid black;
        }

        #myTable tbody {
            background-color: rgba(14, 15, 25, 0.433);
        }
    </style>
</head>

@include('includes._header')
