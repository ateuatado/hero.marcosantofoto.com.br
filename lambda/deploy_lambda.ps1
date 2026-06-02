# Script de Deploy do Lambda hero-process-photo
# Executar este script em uma janela do PowerShell onde o AWS CLI esteja configurado.

$ErrorActionPreference = "Stop"

Write-Host "==============================================" -ForegroundColor Gold
Write-Host "   DEPLOIANDO LAMBDA: hero-process-photo      " -ForegroundColor Gold
Write-Host "==============================================" -ForegroundColor Gold

# Garante que estamos na pasta correta
$ScriptPath = Split-Path -Parent $MyInvocation.MyCommand.Definition
if ($ScriptPath) {
    Set-Location $ScriptPath
}

# Define nomes dos arquivos
$ZipFile = "function.zip"
$SourceFile = "process_photo.py"

# Remove zip antigo se existir
if (Test-Path $ZipFile) {
    Remove-Item $ZipFile -Force
}

Write-Host "[+] Compactando $SourceFile para $ZipFile..." -ForegroundColor Cyan
# Cria arquivo zip contendo apenas o script do Lambda
Compress-Archive -Path $SourceFile -DestinationPath $ZipFile -Force

Write-Host "[+] Atualizando codigo do Lambda na AWS..." -ForegroundColor Cyan
try {
    aws lambda update-function-code `
      --function-name hero-process-photo `
      --zip-file fileb://$ZipFile `
      --region us-east-2
    
    Write-Host "[+] SUCESSO! O codigo do Lambda foi atualizado no AWS." -ForegroundColor Green
} catch {
    Write-Host "[!] ERRO ao enviar codigo para a AWS: $_" -ForegroundColor Red
    Write-Host "[!] Verifique se o AWS CLI esta instalado e autenticado com 'aws configure'." -ForegroundColor Yellow
}

# Limpeza
if (Test-Path $ZipFile) {
    Remove-Item $ZipFile -Force
}

Write-Host "==============================================" -ForegroundColor Gold
