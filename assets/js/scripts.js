// assets/js/scripts.js
$(document).ready(function() {
  // calcula idade e preenche campo 'age'
  function calculateAge(dob) {
    if (!dob) return '';
    const birth = new Date(dob);
    const now = new Date();
    let age = now.getFullYear() - birth.getFullYear();
    const m = now.getMonth() - birth.getMonth();
    if (m < 0 || (m === 0 && now.getDate() < birth.getDate())) {
      age--;
    }
    return age;
  }

  $('#birthdate').on('change', function() {
    $('#age').val(calculateAge(this.value));
  });

  // Templates
  function experienceBlock(index, data = {}) {
    return `
      <div class="card mb-2 p-3 experience-item" data-index="${index}">
        <button type="button" class="btn-close float-end remove-experience" aria-label="Remove"></button>
        <div class="mb-2">
          <label class="form-label">Empresa</label>
          <input name="experience_company[]" class="form-control" value="${data.company||''}">
        </div>
        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Cargo</label>
            <input name="experience_role[]" class="form-control" value="${data.role||''}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Início</label>
            <input name="experience_start[]" type="month" class="form-control" value="${data.start||''}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Término</label>
            <input name="experience_end[]" type="month" class="form-control" value="${data.end||''}">
          </div>
        </div>
        <div class="mt-2">
          <label class="form-label">Descrição</label>
          <textarea name="experience_desc[]" class="form-control" rows="2">${data.desc||''}</textarea>
        </div>
      </div>
    `;
  }

  function referenceBlock(index, data = {}) {
    return `
      <div class="card mb-2 p-3 reference-item" data-index="${index}">
        <button type="button" class="btn-close float-end remove-reference" aria-label="Remove"></button>
        <div class="mb-2">
          <label class="form-label">Nome</label>
          <input name="ref_name[]" class="form-control" value="${data.name||''}">
        </div>
        <div class="mb-2">
          <label class="form-label">Contato</label>
          <input name="ref_contact[]" class="form-control" value="${data.contact||''}">
        </div>
        <div class="mb-2">
          <label class="form-label">Relação</label>
          <input name="ref_relation[]" class="form-control" value="${data.relation||''}">
        </div>
      </div>
    `;
  }

  // Add first empty blocks by default
  let expIndex = 0, refIndex = 0;
  $('#experiencesContainer').append(experienceBlock(expIndex++));
  $('#referencesContainer').append(referenceBlock(refIndex++));

  $('#addExperience').on('click', function(){
    $('#experiencesContainer').append(experienceBlock(expIndex++));
  });

  $('#addReference').on('click', function(){
    $('#referencesContainer').append(referenceBlock(refIndex++));
  });

  // Delegation for remove buttons
  $(document).on('click', '.remove-experience', function(){
    $(this).closest('.experience-item').remove();
  });
  $(document).on('click', '.remove-reference', function(){
    $(this).closest('.reference-item').remove();
  });
});
