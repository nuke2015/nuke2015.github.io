for %%i in (c:,d:,e:,f:,g:,h:) do cacls "%%i\System Volume Information" /e /c /p everyone:f
