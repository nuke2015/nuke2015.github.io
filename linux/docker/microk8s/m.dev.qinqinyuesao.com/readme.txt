
#装载
kb apply -f demo-dev.yaml 

#检查
root@v246:~/app# kb get all
NAME                                   READY   STATUS    RESTARTS   AGE
pod/dev-jjys168-com-6475d7c89c-q8jqz   1/1     Running   0          2m43s

NAME                      TYPE           CLUSTER-IP      EXTERNAL-IP   PORT(S)          AGE
service/dev-jjys168-com   LoadBalancer   10.152.183.77   <pending>     8088:30377/TCP   2m43s
service/kubernetes        ClusterIP      10.152.183.1    <none>        443/TCP          3m31s

NAME                              READY   UP-TO-DATE   AVAILABLE   AGE
deployment.apps/dev-jjys168-com   1/1     1            1           2m43s

NAME                                         DESIRED   CURRENT   READY   AGE
replicaset.apps/dev-jjys168-com-6475d7c89c   1         1         1       2m43s

#访问
curl 127.0.0.1:30377

