
<<<<<<< HEAD
rem 会自动复活
sc delete CryptSvc

rem 去掉没啥用
sc delete WinHttpAutoProxySvc
sc delete FontCache
sc delete CscService
sc delete IKEEXT
sc delete iphlpsvc
sc delete AeLookupSvc
sc delete BFE
sc delete DPS
sc delete WdiServiceHost
sc delete WdiSystemHost
sc delete TrkWks
sc delete PcaSvc
sc delete AMD External Events Utility
sc delete KeyIso

=======
rem 专杀会自动从禁用状态复活的服务
sc delete CryptSvc

>>>>>>> 45c8add... 涔熻鏄釜濂藉姙娉�
