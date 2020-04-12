


直接拉起
kb apply -f mywp.yaml 

检查,都ready拉起成功
root@xihei:~# kb get all
NAME                                  READY   STATUS    RESTARTS   AGE
pod/mywp-mariadb-0                    1/1     Running   0          62s
pod/mywp-wordpress-58c45f668b-wbwws   1/1     Running   0          62s


NAME                     TYPE           CLUSTER-IP       EXTERNAL-IP   PORT(S)                      AGE
service/kubernetes       ClusterIP      10.152.183.1     <none>        443/TCP                      70m
service/mywp-mariadb     ClusterIP      10.152.183.60    <none>        3306/TCP                     62s
service/mywp-wordpress   LoadBalancer   10.152.183.121   <pending>     80:30501/TCP,443:30668/TCP   62s


NAME                             READY   UP-TO-DATE   AVAILABLE   AGE
deployment.apps/mywp-wordpress   1/1     1            1           62s

NAME                                        DESIRED   CURRENT   READY   AGE
replicaset.apps/mywp-wordpress-58c45f668b   1         1         1       62s

NAME                            READY   AGE
statefulset.apps/mywp-mariadb   1/1     62s


