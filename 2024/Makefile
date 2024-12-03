# Variables
APP_NAME=my-typescript-app
DOCKER_IMAGE=my-typescript-app-image
DOCKER_CONTAINER=my-typescript-app-container
DOCKERFILE=Dockerfile
SOURCE_DIR=src
DIST_DIR=dist

# Commandes
DOCKER=docker
DOCKER_RUN=$(DOCKER) run --rm -v $(PWD):/app -w /app -u 1000 $(DOCKER_IMAGE)

# Cibles
.PHONY: all clean docker-build docker-run docker-stop npm-install npm-build npm-bash npm-generate-files

all: clean docker-build npm-install npm-build docker-run

clean:
	@echo "Cleaning up..."
	rm -rf $(DIST_DIR) node_modules
	$(DOCKER) rm -f $(DOCKER_CONTAINER) || true
	$(DOCKER) rmi -f $(DOCKER_IMAGE) || true

docker-build:
	@echo "Building Docker image..."
	$(DOCKER) build -t $(DOCKER_IMAGE) -f $(DOCKERFILE) .

npm-install:
	@echo "Running npm install in the container..."
	$(DOCKER_RUN) npm install

npm-bash:
	@echo "Running npm install in the container..."
	$(DOCKER) run -it --rm -u 1000 -v $(PWD):/app -w /app $(DOCKER_IMAGE) bash

npm-build:
	@echo "Building TypeScript project in the container..."
	$(DOCKER_RUN) npm run build

npm-start:
	@echo "Start TypeScript project in the container..."
	$(DOCKER_RUN) npm start

npm-generate-files: npm-install npm-build
	@echo "generate files"
	$(DOCKER_RUN) npm run generate-files

npm-day: npm-install npm-build
	@echo "day"
	$(DOCKER_RUN) node dist/day-$(DAY).js

docker-run:
	@echo "Running Docker container..."
	$(DOCKER) run --rm -it \
		-v $(PWD)/$(DIST_DIR):/app/$(DIST_DIR) \
		-p 3000:3000 \
		--name $(DOCKER_CONTAINER) \
		$(DOCKER_IMAGE)

docker-stop:
	@echo "Stopping Docker container..."
	-$(DOCKER) stop $(DOCKER_CONTAINER)

