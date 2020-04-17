root@v246:~/app# kb apply -f demo-dev.yaml 
service/dev-jjys168-com created
deployment.apps/dev-jjys168-com created
root@v246:~/app# kb get all
NAME                                  READY   STATUS    RESTARTS   AGE
pod/dev-jjys168-com-6bc497cd4-8rrnk   1/1     Running   0          4s

NAME                      TYPE           CLUSTER-IP      EXTERNAL-IP   PORT(S)        AGE
service/dev-jjys168-com   LoadBalancer   10.152.183.73   <pending>     80:30598/TCP   4s
service/kubernetes        ClusterIP      10.152.183.1    <none>        443/TCP        46s

NAME                              READY   UP-TO-DATE   AVAILABLE   AGE
deployment.apps/dev-jjys168-com   1/1     1            1           4s

NAME                                        DESIRED   CURRENT   READY   AGE
replicaset.apps/dev-jjys168-com-6bc497cd4   1         1         1       4s



volume挂载成功!

