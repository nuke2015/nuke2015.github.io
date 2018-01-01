FROM ubuntu:latest

COPY sources.list /etc/apt/sources.list

RUN apt-get update \
&& apt-get install -y cron lrzsz unzip net-tools iputils-ping net-tools wget vim \
&& apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/apt/* \
&& echo "done"

# Define working directory.
WORKDIR /data

# Define default command.
CMD ["bash"]

