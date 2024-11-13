if [ -z "$1" ]; then
    echo "Usage: log.sh [php|nginx|mysql]"
    exit 1
fi

docker-compose logs -f $1
