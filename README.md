# BOOKPICK


<회원정보 관련 수정사항>


1. 유저모델 참조 4개 테이블 softdelete처리 되도록 설정

2. 삭제 레코드 포함 모든 레코드 조회 $records = 모델명::withTrashed()->get();

3. 삭제 레코드만 조회 $deletedRecords = 모델명::onlyTrashed()->get();

4. 삭제 레코드 복구 모델명::withTrashed()->where('조건')->restore();

5. 미들웨어 유효성 검사 추가 수정

6. 유저컨트롤러 로그 작업