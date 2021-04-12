<template>
  <div >
    <v-tabs
    v-model="tab"
    >
      <v-tab href="#tab-1">This Meal</v-tab>
      <v-tab href="#tab-2">Prices</v-tab>
    </v-tabs>
    
    

      <v-tabs-items v-model="tab" class="pt-4">
        <v-tab-item
          :key="2"
          :value="'tab-' + 2"
        >
        <mealPrices v-bind:codMealId="codMealId"/>
        </v-tab-item>
        
        <v-tab-item
          :key="1"
          :value="'tab-' + 1"
        >
        <template >
          <a-form  :form="form" @submit="handleSubmit" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" >
          <a-row> 
            <a-form-item label="Picture of meal">
              <div class="dropbox">
            <a-upload
              name="picture"
              list-type="picture-card"
              class="avatar-uploader"
              :show-upload-list="false"
              action="/cwqafkxr_eat_in_more/public/api/filePicture"
              :before-upload="beforeUpload"
              @change="handleChange"
            >
              <img v-if="imageUrl" :src="imageUrl" alt="avatar" class="picture_avatar" />
              <div v-else>
                <a-icon :type="loading ? 'loading' : 'plus'" />
                <div class="ant-upload-text">
                  Upload
                </div>
              </div>
            </a-upload>

              </div>
            </a-form-item>

            <a-form-item label="Name (short)" :validate-status="nameError() ? 'error' : ''" :help="nameError() || ''">
              <a-input
                v-decorator="[
                  'name',
                  { initialValue:this.thisMeal.name,rules: [{ required: true, message: 'Please input meal name!' }] },
                ]"
                placeholder="Name"
                allow-clear
              >
              </a-input>
            </a-form-item>

            <a-form-item label="Alias (full)" :validate-status="aliasError() ? 'error' : ''" :help="aliasError() || ''">
              <a-input
                v-decorator="[
                  'alias',
                  { initialValue:this.thisMeal.alias,rules: [{ required: true, message: 'Please input meal alias!' }] },
                ]"
                placeholder="Alias"
                allow-clear
              >
              </a-input>
            </a-form-item>

            <a-form-item label="Details" :validate-status="detailsError() ? 'error' : ''" :help="detailsError() || ''">
              <a-textarea 
                placeholder="Details about the meal" 
                :rows="2"
                v-decorator="[
                  'details',
                  { initialValue:this.thisMeal.details,rules: [{ required: true, message: 'Please input meal details!' }] },
                ]" 

                allow-clear

              />
            </a-form-item>

            <a-form-item label="Cuisine" :validate-status="cuisineError() ? 'error' : ''" :help="cuisineError() || ''">
              <a-select
                show-search
                option-filter-prop="children"
                :filter-option="filterOption"
                v-decorator="[
                  'cuisine',
                  { initialValue:this.thisMeal.cuisine_id,rules: [{ required: true, message: 'Please input Cuisine!' }] },
                ]"
                placeholder="Select Cuisine"
              >
                <a-select-option v-for="cuisine in cuisines"  v-bind:value="cuisine.id" :key="cuisine.id" >
                  {{ cuisine.name }}
                </a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item label="Experience" :validate-status="experienceError() ? 'error' : ''" :help="experienceError() || ''">
              <a-select
                v-decorator="[
                  'experience',
                  { initialValue:this.thisMeal.experience_id,rules: [{ required: true, message: 'Please input your experience!' }] },
                ]"
                placeholder="Select Experience"
              >
                <a-select-option v-for="experience in experiences"  v-bind:value="experience.id" :key="experience.id" >
                  ({{ experience.ref }}) {{ experience.title }} - {{ experience.description }}
                </a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item label="Type" :validate-status="mealTypeError() ? 'error' : ''" :help="mealTypeError() || ''">
              <a-select
                v-decorator="[
                  'mealType',
                  { initialValue:this.thisMeal.type_meal_id,rules: [{ required: true, message: 'Please input Meal type!' }] },
                ]"
                placeholder="Select type"
              >
                <a-select-option v-for="mealType in mealTypes"  v-bind:value="mealType.id" :key="mealType.id" >
                  {{ mealType.meal_type }}
                </a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item label="Common Timing" :validate-status="commonTimingError() ? 'error' : ''" :help="commonTimingError() || ''">
              <a-select
                v-decorator="[
                  'commonTiming',
                  { initialValue:this.thisMeal.common_timing_id,rules: [{ required: true, message: 'Please input Common Timing!' }] },
                ]"
                placeholder="Select Common Timing"
              >
                <a-select-option v-for="commonTiming in commonTimings"  v-bind:value="commonTiming.id" :key="commonTiming.id" >
                  {{ commonTiming.common_timing }}
                </a-select-option>
              </a-select>
            </a-form-item>


            <a-form-item label="Durraction (minutes)"  :validate-status="timeError() ? 'error' : ''" :help="timeError() || ''">
              
              <a-input-number  :min="1" :max="1000" style="marginLeft: 16px" 

              v-decorator="[
              'time',
                  {
                    initialValue:this.thisMeal.time, rules: [{required: true, message: 'Please input a Time!' }],
                  },
                ]"

              />
            </a-form-item>


            <a-form-item label="People" :validate-status="peopleError() ? 'error' : ''" :help="peopleError() || ''" >

            <a-row>
              <a-col :span="4" >
                <a-input-number  :min="1" :max="1000" style="marginLeft: 16px" 

              v-decorator="[
              'people',
                  {
                    initialValue:inputValue1, rules: [{required: true, message: 'Please input a number of people!' }],
                  },
                ]"

                />
              </a-col>
            </a-row>

            </a-form-item>



            <a-form-item label="Allergies" :validate-status="ingredientsError() ? 'error' : ''" :help="ingredientsError() || ''" >
              <template>
                <a-select mode="multiple" style="width: 100%" placeholder="Select Allergies" @change="handleingreChange"

                  v-decorator="[
                  'ingredients',
                      {
                        initialValue:inIngredients,rules: [{ required: true, message: 'Please input ingredients!' }],
                      },
                    ]"
                  >
                
                  <a-select-option v-for="ingredient in ingredients" v-bind:value="ingredient.id" :key="ingredient.id">
                    {{ingredient.name}} - {{ingredient.description}}
                  </a-select-option>
                </a-select>
              </template>
            </a-form-item>

            

            <a-form-item label="Options" :validate-status="optionsError() ? 'error' : ''" :help="optionsError() || ''" >
                <template>
                  <a-select mode="tags" style="width: 100%" :token-separators="[',']" @change="handleOptChange"       
                  v-decorator="[
                  'options',
                      {
                          initialValue:iniOpttions,rules: [{ required: false, message: 'Please input options!' }],
                      },
                    ]"
                    >
                    <a-select-option v-for="option in options" :key="option.name">
                      {{ option.name }}
                    </a-select-option>
                  </a-select>
                </template>
            </a-form-item>

            <a-form-item label="Tags">
              <template v-for="tag in tags">
                <a-checkable-tag
                  :key="tag.id"
                  :checked="selectedTags.indexOf(tag.id) > -1"
                  @change="checked => handletagChange(tag.id, checked)"  
                >
                  {{ tag.name }}
                </a-checkable-tag>
              </template>
            </a-form-item>

            <a-form-item >
              <a-col :xs="{ span: 24, offset: 0}" :lg="{ span: 20, offset: 10}"> 
                  <a-button icon="check-circle"  type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())" >
                      Update
                  </a-button >
              </a-col>
            </a-form-item>
          </a-row>
          </a-form>
        </template>
        </v-tab-item>
      </v-tabs-items>
  </div> 
</template>

<script>
import mealPrices from './Prices.vue';

function getBase64(img, callback) {
  const reader = new FileReader();
  reader.addEventListener('load', () => callback(reader.result));
  reader.readAsDataURL(img);
}
function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
export default {
  components: { mealPrices},
    props: {
        codMealId: null,
        
    },
  data() {
    return {
      tab:null,
      inputValue: 0,
      inputValue1: 1,
      loading: false,
      imageUrl: '',
      hasErrors,
      formLayout: 'horizontal',
      form: this.$form.createForm(this, { name: 'coordinated' }),
      experiences:'',
      fileInfo:'',
      userInfo: localStorage.getItem('user'),
      userID: '',
      chefeCV: '',
      commonTimings: '',
      currencys: '',
      tags: [],
      selectedTags: [],
      cuisines:null,
      ingredients:null,
      thisMeal:[],
      options:[],
      iniOpttions:[],
      inIngredients:[],
      mealTypes:[],
    };
  },
    watch: {
    codMealId: {
      handler (val) {
        //console.log('watch', val);
        axios
            .get('getThisMeal/'+this.codMealId)
            .then(response => (this.inputValue1=response.data.people,this.handleIngredients(response.data.meal_allergies),this.handletags(response.data.meal_tags),this.handleOptions(response.data.meal_options),this.thisMeal = response.data,this.imageUrl = 'storage/'+response.data.meal_file.path+response.data.meal_file.name));
      },
      deep: true,
      immediate: true
    },

    },
    
  methods: {
    filterOption(input, option) {
      return (
        option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      );
    },
    handleingreChange(value) {
      //console.log(`selected ${value}`);
    },
    
    handleIngredients(list){
      var ingredients=[];
        list.map (function(value,key) {
          ingredients.push(value.ingredients_id);
        });

      this.inIngredients = ingredients;
    },
    handletags(list){
      var tags=[];
        list.map (function(value,key) {
          tags.push(value.tag_id);
        });

      this.selectedTags = tags;
    },
    
    handleOptions(list){
      var options=[];
        list.map (function(value,key) {
          options.push(value.name);
        });

      this.iniOpttions = options;
    },

    handletagChange(tag, checked) {
      const { selectedTags } = this;
      const nextSelectedTags = checked
        ? [...selectedTags, tag]
        : selectedTags.filter(t => t !== tag);
      //console.log('You are interested in: ', nextSelectedTags);
      this.selectedTags = nextSelectedTags;
    },
    handleChange(info) {
      if (info.file.status === 'uploading') {
        this.loading = true;
        return;
      }
      if (info.file.status === 'done') {
        this.fileInfo=info.file.response;
        // Get this url from response in real world.
        getBase64(info.file.originFileObj, imageUrl => {
          this.imageUrl = imageUrl;
          this.loading = false;
        });
      }
    },
    handleOptChange(value) {
      console.log(`selected ${value}`);
    },
    beforeUpload(file) {
      const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
      if (!isJpgOrPng) {
        this.$message.error('You can only upload JPG file!');
      }
      const isLt2M = file.size / 1024 / 1024 < 10;
      if (!isLt2M) {
        this.$message.error('Image must smaller than 10MB!');
      }
      return isJpgOrPng && isLt2M;
    },
    handleConfirmBlur(e) {
      const value = e.target.value;
      this.confirmDirty = this.confirmDirty || !!value;
    },

    // Only show error after a field is touched.
    nameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('name') && getFieldError('name');
    },
    
    aliasError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('alias') && getFieldError('alias');
    },

    detailsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('details') && getFieldError('details');
    },
    experienceError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('experience') && getFieldError('experience');
    },
    optionsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('options') && getFieldError('options');
    },
    timeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('time') && getFieldError('time');
    },
    peopleError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('people') && getFieldError('people');
    },
    mealTypeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('mealType') && getFieldError('mealType');
    },
    commonTimingError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('commonTiming') && getFieldError('commonTiming');
    },
    ingredientsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('ingredients') && getFieldError('ingredients');
    },
    cuisineError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('cuisine') && getFieldError('cuisine');
    },
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          console.log('Received values of form: ', values);
          this.sendData(values);
        }
      });
    },
  sendData(data) {
      axios
      .post("update/meal/"+this.codMealId, { data: { mealData: data, tags:this.selectedTags, fileData:this.fileInfo} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been store all data successfully');
              //this.$router.push({ name: 'register/result' });
          }
      })
      .catch((error) => {
          this.success = false;
        var errors =null;
        var status=error.response.status;
        //console.log(status);
            if (status == 422){
            errors=error.response.data.errors;
            //console.log(errors);
            errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
          }else{
            this.openNotification('error','Error on Save',error);
          }
      });
  },
    openNotification: function (type, m, d) {
        this.$notification.config({
            placement: 'topRight',
            top: 35,
            duration: 8,
        });
        this.$notification[type]({
          message: m,
          description: d,
        });
    },
  },

  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.userID = userData.logged_in_user.id;
    
    this.$nextTick(() => {
      // To disabled submit button at the beginning.
      this.form.validateFields();
    });

  axios
      .get('getExperiences')
      .then(response => (this.experiences = response.data));
  axios
      .get('getCommonTiming')
      .then(response => (this.commonTimings = response.data));   
  axios
      .get('getTimeCurrency')
      .then(response => (this.currencys = response.data));
  axios
      .get('getCuisines')
      .then(response => (this.cuisines = response.data)); 
  axios
      .get('getIngredients')
      .then(response => (this.ingredients = response.data)); 
  axios
      .get('getTags/2')
      .then(response => (this.tags = response.data));
  axios
      .get('getCVData/'+this.userID)
      .then(response => (this.chefeCV = response.data));
      
  axios
      .get('getOptions')
      .then(response => (this.options = response.data));
  axios
      .get('getMealType')
      .then(response => (this.mealTypes = response.data));
    //console.log(this.codMealId);
  },
};
</script>
<style>
.avatar-uploader > .ant-upload {
  width: 128px;
  height: 128px;
}
.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}

.picture_avatar {
  width: 200px;
  height: 200px;
}
.code-box-demo .ant-slider {
  margin-bottom: 16px;
}
</style>

