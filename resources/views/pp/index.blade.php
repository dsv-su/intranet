@extends('layouts.app')
<style>
    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .container > div {
        flex: 1;
        max-width: 300px;
    }
</style>
<livewire:project-proposal />
