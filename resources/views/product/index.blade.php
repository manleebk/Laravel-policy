@extends('layout.master')
@php
$title = 'Home | product';
@endphp

@section('main')
@stop

@section('script')
<script>
    $(document).ready(function() {

        console.log('tokenn: ' + getCookie('api_token'));
        loadProduct(); /* function from public/js/utils.js */
        /* ========================================================================
         * Click to edit
         * ========================================================================
         */
        $(document).on('click', '.edit', function() {
            $('.error').remove();
            let id = $(this).attr('id');
            $.ajax({
                url: '/api/product/detail/' + id,
                method: 'get',
                data: {},
                headers: {
                    'Authorization': 'Bearer ' + getCookie('api_token')
                },
                success: function(response) {
                    if (response.success) {
                        let product = response.data;
                        let content = '<input type="text" class = "form-control prd my-2" value="' + product.product_name + '"/>' +
                            '<button class="btn btn-success save mx-2" idVal="' + product.id + '">Save</button>' +
                            '<button class="btn btn-danger cancel">Cancel</button>';
                        $('#content-page').html(content);
                    } else {
                        $('#content-page').append('<p class="error text-danger">' + response.error + '</p>');
                    }
                }
            });
        });

        /* ========================================================================
         * Click save after edit
         * ========================================================================
         */
        $(document).on('click', '.save', function() {
            let id = $('.save').attr('idVal');
            let product_name = $('.prd').val();
            console.log(product_name + ' : ' + id);
            $.ajax({
                url: '/api/product/update/' + id,
                method: 'post',
                data: {
                    product_name: product_name
                },
                headers: {
                    'Authorization': 'Bearer ' + getCookie('api_token')
                },
                success: function(response) {
                    loadProduct();
                }
            });
        });

        /* ========================================================================
         * Click cancel update
         * ========================================================================
         */
        $(document).on('click', '.cancel', function() {
            loadProduct();
        });

        /* ========================================================================
         * Click to add product
         * ========================================================================
         */
        // load interface
        $(document).on('click', '.add', function(e) {
            e.preventDefault();
            let content = '<input type="text" class = "form-control prd my-2"/>' +
                '<button class="btn btn-success add-db mx-2">Add product</button>' +
                '<button class="btn btn-danger cancel">Cancel</button>';
            $('#content-page').html(content);
        });

        $(document).on('click', '.add-db', function() {
            $('.error').remove();
            let product_name = $('.prd').val();
            console.log('Add to db: ' + product_name);
            $.ajax({
                url: '/api/product/add',
                method: 'post',
                data: {
                    product_name: product_name
                },
                headers: {
                    'Authorization': 'Bearer ' + getCookie('api_token')
                },
                success: function(response) {
                    if (response.success) {
                        loadProduct();
                    } else {
                        $('#content-page').append('<p class="error text-danger">' + response.error + '</p>');
                    }
                }
            });
        });
        /* ========================================================================
         * Click to home
         * ========================================================================
         */
        $(document).on('click', '.home', function(e) {
            e.preventDefault();
            loadProduct();
        });
        /* ========================================================================
         * Click to logout
         * ========================================================================
         */
        $(document).on('click', '.logout', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/api/user/logout',
                method: 'get',
                data: {},
                headers: {
                    'Authorization': 'Bearer ' + getCookie('api_token')
                },
                success: function(response) {
                    if (response.success) {
                        document.cookie = 'api_token=' + null;
                        window.location = '/login';
                    }
                }
            });
        });
    });
</script>

@stop