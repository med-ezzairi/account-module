@extends('account::layouts.master')
@section('account')
<h1>Permissions et groupes d'utilisateurs</h1>

<p>
	Ce module permet de créer des groupes et leur assigner des permissions, puis ajouter des utilisateurs à ces groupes.<br>
	Attribuer des permissions à des utilisateurs directement, ou enlever/interdir des permissions à des utilisateurs.<br>
	par exemple, si un utilisateur appartient à un groupe nous avons la possibilité de lui enlever une permission hérité depuis le groupe.
</p>
@endsection
