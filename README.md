# 김봉규 Resume APIs
## 1.김봉규 Resume APIs 관련 문서입니다.
> 기본적인 이력서 내용과 여태까지 진행하였던 프로젝트와 관련된 경력에 대한 내용을 담고 있습니다.   
> www.example.com   
> 해당 사이트에서 구현된 내용을 확인 하실수 있습니다.   
> Front-end는 Vue.js로 구현 하였으며 Back-end는 php와 laravel Framework로 구현 하였습니다.   
> 각 API의 자세한 사항은 아래의 SwaggerHub의 문서를 확인해주시길 바랍니다.   
> https://app.swaggerhub.com/apis-docs/Bnine/Bnine-resume-api/1.0.0#/
## 1.1. API관련 안내 사항
> 1. 모든 API는 무분별한 호출로 인해 개인정보가 노출 되는 것을 막기 위해 App\Http\Middleware\CheckBearer Class에 의해 검증을 하도록 구현되어 있습니다.
> 2. 만약 Web Access가 아닌 직접 postman이나 다른 방법으로 API를 직접 호출 하시고자 하는 경우 다음과 같은 Bearer 토큰을 사용하여 주십시요.  Authorization: Bearer VkdZMXJ2RldCeldFYTRwWDI5QWRXdWptRW8zV1RvRFU2a1ByRnJReDF1QnNFUlNHU05tREFDczdGZlBCVjdQOHhSOVlEVnFsUUdLZkhaU2g=
> 3. profile과 work-experience 두 API는 파라미터로 {m_id}을 반드시 필요로 하고 있습니다. 
> 4. 만약 Web Access가 아닌 직접 postman이나 다른 방법으로 위의 두 API를 직접 호출 하시고자 하는 경우 파라미터로 다음과 같은 값을 사용하여 주십시요.  91aad9dc-6f36-4603-ad4a-f5882161927b
## 2. API 디렉토리 구성
- Controller
```
    - MainController 컨트롤러(모든 resume APIs 요청을 처리 하는 컨트롤러)
        - /app/Http/Controllers/MainController.php
```
- Service
```
    - MainService 서비스 클래스(비지니스 로직 구현 클래스)
        - /app/Services/MainService.php
```
- Repository
```
    - BaseRepository 리포지토리 클래스(공통 로직을 위한 상속용 클래스)
        - /app/Repositories/BaseRepository.php
    - MainRepository 리포지토리 클래스(resume API 데이터 처리를 위한 클래스)
        - /app/Repositories/MainRepository.php
```
- Model
```
    - Main 모델 클래스
        - /app/Main.php
    - Image 모델 클래스
        - /app/Image.php
```
- Interface
```
    - BaseRepositoryInterface 인터페이스(공통 로직을 위한 상속용 인터페이스)
        - app/Repositories/Interfaces/BaseRepositoryInterface.php
    - MainRepositoryInterface 인터페이스(MainRepository 리포지토리 클래스에서 사용할 인터페이스)
        - app/Repositories/Interfaces/MainRepositoryInterface.php
```
- Middleware
```
    - CheckBearer 미들웨어(임의로 만들어진 토큰 값을 이용해 자격이 있는 Request만 받아 들이고 아닌 경우 403 error response)
        - app/Http/Middleware/CheckBearer.php
```
- Route
```
    - API 서비스 라우팅
        - routes/api.php
```
- Customized Config
```
    - Common Values (공통적으로 쓰이면서 따로 파일별로 그룹화가 불필요한 값들)
        - config/common.php
    - aws service 관련 일반적인 값
        - config/awsconfig.php
```
