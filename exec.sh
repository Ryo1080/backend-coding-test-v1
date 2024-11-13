if [ -z "$1" ]; then
    echo "Usage: exec.sh [php|nginx|mysql]"
    exit 1
fi

docker exec -it backend-coding-test-v1_$1 /bin/bash
