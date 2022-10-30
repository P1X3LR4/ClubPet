<?php

function FunctionName($dado, $operation)
{
    if ($operation == 'agendamento') {
        switch ($dado) {
            case 'agen_nome_pet':
                return "Nome do Pet";
                break;

            case 'agen_servico':
                return "Serviços";
                break;

            case 'agen_pagamento':
                return "Forma de Pagamento";
                break;

            case 'agen_horario':
                return "Horário";
                break;

            case 'agen_image':
                return "Imagem do Pet";
                break;

            case 'agen_raca':
                return "Espécie/Raça";
                break;

            case 'agen_sexo':
                return "Sexo";
                break;

            default:
                return "Data";
                break;
        }
    }
    if ($operation == 'registrar-cliente') {
        switch ($dado) {
            case 'cli_nome':
                return "Nome Completo";
                break;

            case 'cli_cpf':
                return "CPF";
                break;

            case 'cli_telefone':
                return "Telefone";
                break;

            case 'cli_endereco':
                return "Endereço";
                break;

            case 'cli_email':
                return "Email";
                break;
            default:
                return "Senha";
                break;
        }
    }
    if ($operation == 'login-cliente') {
        switch ($dado) {
            case 'cli_login_email':
                return "Email";
                break;

            default:
                return "Senha";
                break;
        }
    }
    if ($operation == 'registrar-funcionario') {
        switch ($dado) {
            case 'func_nome':
                return "Nome do Funcionário";
                break;

            case 'func_telefone':
                return "Telefone";
                break;

            case 'func_email':
                return "Email";
                break;

            case 'func_cpf':
                return "CPF";
                break;

            case 'func_cargo':
                return "Cargo";
                break;

            default:
                return "Senha";
                break;
        }
    }
}

function resetDadosSessions($post, $dados)
{
    if (isset($post)) {

        foreach ($dados as $dado => $value) {
            unset($_SESSION[$dado]);
        }
    }
}

function setColor($setColor)
{
    switch ($setColor) {
        case 'error':
            return 'danger';
            break;

        case 'success':
            return 'success';
            break;

        case 'info':
            return 'primary';
            break;

        default:
            return 'warning';
            break;
    }
}
