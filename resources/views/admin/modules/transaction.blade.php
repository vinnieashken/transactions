@extends('admin.includes.body')
@section('title', 'Transaction')
@section('subtitle','Transaction')
@section('content')
   <div class="card">

       <div class="card-body">
           <table id="transactions" class="table table-striped table-hover custom-list-table">
               <thead>
                   <tr>
                       <th>Product</th>
                       <th>TransId</th>
                       <th>Mpesa Code</th>
                       <th>Amount</th>
                       <th>Telephone No</th>
                       <th>Time</th>
                   </tr>
               </thead>
               <tfoot>
                   <tr>
                       <th>Product</th>
                       <th>TransId</th>
                       <th>Mpesa Code</th>
                       <th>Amount</th>
                       <th>Telephone No</th>
                       <th>Time</th>
                   </tr>
               </tfoot>
           </table>
           {{ getprefix('Ep0ki008') }}
       </div>
   </div>
@endsection

